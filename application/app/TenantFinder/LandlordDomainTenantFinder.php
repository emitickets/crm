<?php

namespace App\TenantFinder;

use Spatie\Multitenancy\TenantFinder\TenantFinder;
use App\Models\Multitenancy\Tenant;
use Illuminate\Support\Facades\Log;

class LandlordDomainTenantFinder extends TenantFinder
{
    /**
     * Find a tenant by domain name using the landlord database connection
     *
     * @return Tenant|null
     */
    public function findForRequest($request): ?Tenant
    {
        // Get the host from the request
        $host = $request->getHost();
        $originalHost = $host;
        $host = str_replace('www.', '', $host);

        // Log initial request details
        Log::info('TenantFinder: Starting tenant search', [
            'original_host' => $originalHost,
            'processed_host' => $host,
            'full_url' => $request->url(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);

        // Skip tenant finding for landlord routes
        if ($this->isLandlordRequest($request)) {
            Log::info('TenantFinder: Skipping - this is a landlord request', [
                'host' => $host,
            ]);
            return null;
        }

        // Skip tenant finding for frontend routes
        if ($this->isFrontendRequest($request)) {
            Log::info('TenantFinder: Skipping - this is a frontend request', [
                'host' => $host,
            ]);
            return null;
        }

        Log::info('TenantFinder: Proceeding with tenant search', [
            'host' => $host,
            'url' => $request->url(),
        ]);

        // First try to find using App\Models\Landlord\Tenant to verify it exists
        Log::info('TenantFinder: Searching in Landlord\Tenant model', [
            'host' => $host,
            'connection' => 'landlord',
        ]);

        try {
            $landlordTenant = \App\Models\Landlord\Tenant::on('landlord')
                ->where('domain', $host)
                ->first();

            // If not found by domain, try searching by subdomain
            if (!$landlordTenant) {
                Log::info('TenantFinder: Not found by domain, trying subdomain', [
                    'host' => $host,
                ]);
                
                // Extract subdomain from host (e.g., "subdomain.example.com" -> "subdomain")
                $hostParts = explode('.', $host);
                if (count($hostParts) > 2) {
                    $possibleSubdomain = $hostParts[0];
                    Log::info('TenantFinder: Trying to find by subdomain', [
                        'extracted_subdomain' => $possibleSubdomain,
                        'full_host' => $host,
                    ]);
                    
                    $landlordTenant = \App\Models\Landlord\Tenant::on('landlord')
                        ->where('subdomain', $possibleSubdomain)
                        ->first();
                }
            }

            if (!$landlordTenant) {
                // Try to see what domains exist for debugging
                try {
                    $allTenants = \App\Models\Landlord\Tenant::on('landlord')
                        ->select('tenant_id', 'domain', 'subdomain')
                        ->limit(10)
                        ->get();
                    
                    Log::warning('TenantFinder: Tenant not found in Landlord\Tenant model', [
                        'searched_host' => $host,
                        'available_tenants_sample' => $allTenants->pluck('domain', 'tenant_id')->toArray(),
                        'total_tenants_count' => \App\Models\Landlord\Tenant::on('landlord')->count(),
                    ]);
                } catch (\Exception $e) {
                    Log::error('TenantFinder: Error querying tenants for debugging', [
                        'error' => $e->getMessage(),
                        'searched_host' => $host,
                    ]);
                }
                return null;
            }
        } catch (\Exception $e) {
            Log::error('TenantFinder: Database connection error when searching for tenant', [
                'error' => $e->getMessage(),
                'host' => $host,
                'connection' => 'landlord',
            ]);
            return null;
        }

        Log::info('TenantFinder: Found tenant in Landlord\Tenant model', [
            'tenant_id' => $landlordTenant->tenant_id,
            'domain' => $landlordTenant->domain,
            'subdomain' => $landlordTenant->subdomain ?? 'N/A',
            'database' => $landlordTenant->database ?? 'N/A',
            'tenant_name' => $landlordTenant->tenant_name ?? 'N/A',
            'tenant_status' => $landlordTenant->tenant_status ?? 'N/A',
        ]);

        // Find tenant using Spatie's Tenant model (our custom one that extends it)
        // This will work with Spatie's multitenancy system
        Log::info('TenantFinder: Searching Spatie Tenant model by domain', [
            'host' => $host,
        ]);
        
        $tenant = Tenant::on('landlord')
            ->where('domain', $host)
            ->first();

        if (!$tenant) {
            // If not found by domain, try by tenant_id
            Log::info('TenantFinder: Not found by domain, trying by tenant_id', [
                'tenant_id' => $landlordTenant->tenant_id,
            ]);
            
            $tenant = Tenant::on('landlord')
                ->where('tenant_id', $landlordTenant->tenant_id)
                ->first();
        }

        if ($tenant) {
            Log::info('TenantFinder: Found tenant in Spatie Tenant model', [
                'tenant_id' => $tenant->getKey(),
                'domain' => $tenant->domain ?? 'N/A',
                'database' => $tenant->database ?? 'N/A',
            ]);
        } else {
            Log::warning('TenantFinder: Tenant not found in Spatie Tenant model', [
                'searched_host' => $host,
                'landlord_tenant_id' => $landlordTenant->tenant_id,
            ]);
        }

        if ($tenant) {
            Log::info('TenantFinder: ✅ Successfully found/created tenant - RETURNING', [
                'tenant_id' => $tenant->getKey(),
                'domain' => $tenant->domain ?? $landlordTenant->domain,
                'database' => $tenant->database ?? $landlordTenant->database ?? 'unknown',
                'connection' => $tenant->getConnectionName(),
            ]);
        } else {
            Log::error('TenantFinder: ❌ Failed to create Tenant instance', [
                'landlord_tenant_id' => $landlordTenant->tenant_id,
                'domain' => $landlordTenant->domain,
            ]);
        }

        return $tenant;
    }

    /**
     * Check if this is a landlord request
     */
    private function isLandlordRequest($request): bool
    {
        $url = $request->url();
        $host = str_replace('www.', '', $request->getHost());
        
        // Check if URL contains '/app-admin'
        if (strpos($url, '/app-admin') !== false) {
            Log::info('TenantFinder: Detected landlord request (URL contains /app-admin)', [
                'url' => $url,
                'host' => $host,
            ]);
            return true;
        }

        // Check if domain matches LANDLORD_DOMAIN
        $landlordDomain = env('LANDLORD_DOMAIN', '');
        if ($landlordDomain != '') {
            $domains_list = explode(',', preg_replace('/\s+/', '', $landlordDomain));
            Log::info('TenantFinder: Checking against LANDLORD_DOMAIN', [
                'landlord_domains' => $domains_list,
                'request_host' => $host,
            ]);
            if (in_array($host, $domains_list)) {
                Log::info('TenantFinder: Detected landlord request (domain matches LANDLORD_DOMAIN)', [
                    'host' => $host,
                    'matched_domain' => $host,
                ]);
                return true;
            }
        } else {
            Log::info('TenantFinder: LANDLORD_DOMAIN not set in .env', [
                'host' => $host,
            ]);
        }

        return false;
    }

    /**
     * Check if this is a frontend request
     */
    private function isFrontendRequest($request): bool
    {
        $frontendDomain = env('FRONTEND_DOMAIN', '');
        $host = str_replace('www.', '', $request->getHost());
        
        if ($frontendDomain != '') {
            $frontendDomainClean = trim(strtolower($frontendDomain));
            Log::info('TenantFinder: Checking against FRONTEND_DOMAIN', [
                'frontend_domain' => $frontendDomainClean,
                'request_host' => $host,
            ]);
            if ($host == $frontendDomainClean) {
                Log::info('TenantFinder: Detected frontend request (domain matches FRONTEND_DOMAIN)', [
                    'host' => $host,
                ]);
                return true;
            }
        } else {
            Log::info('TenantFinder: FRONTEND_DOMAIN not set in .env', [
                'host' => $host,
            ]);
        }

        return false;
    }
}

