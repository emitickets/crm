<?php

namespace App\TenantFinder;

use Spatie\Multitenancy\TenantFinder\TenantFinder;
use Spatie\Multitenancy\Models\Tenant;
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
        // Skip tenant finding for landlord routes
        if ($this->isLandlordRequest($request)) {
            return null;
        }

        // Skip tenant finding for frontend routes
        if ($this->isFrontendRequest($request)) {
            return null;
        }

        // Get the host from the request
        $host = $request->getHost();
        $host = str_replace('www.', '', $host);

        // Log for debugging
        Log::info('TenantFinder: Searching for tenant', [
            'host' => $host,
            'url' => $request->url(),
        ]);

        // First try to find using App\Models\Landlord\Tenant to verify it exists
        $landlordTenant = \App\Models\Landlord\Tenant::on('landlord')
            ->where('domain', $host)
            ->first();

        if (!$landlordTenant) {
            Log::warning('TenantFinder: Tenant not found in Landlord\Tenant model', [
                'host' => $host,
            ]);
            return null;
        }

        Log::info('TenantFinder: Found tenant in Landlord\Tenant', [
            'tenant_id' => $landlordTenant->tenant_id,
            'domain' => $landlordTenant->domain,
        ]);

        // Find tenant in landlord database using Spatie Tenant model
        // Try different approaches since the Spatie model might use 'id' instead of 'tenant_id'
        $tenant = null;
        
        // First try: search by domain (both models should have this field)
        $tenant = Tenant::on('landlord')
            ->where('domain', $host)
            ->first();

        // Second try: if not found, search by id (Spatie uses 'id', Landlord uses 'tenant_id')
        if (!$tenant) {
            $tenant = Tenant::on('landlord')
                ->where('id', $landlordTenant->tenant_id)
                ->first();
        }

        // Third try: create a new Tenant instance from the LandlordTenant data
        // This ensures we always return a valid Tenant instance
        if (!$tenant) {
            Log::info('TenantFinder: Creating Tenant instance from LandlordTenant', [
                'tenant_id' => $landlordTenant->tenant_id,
            ]);
            
            // Create a new Tenant instance and populate it with data from LandlordTenant
            $tenant = new Tenant();
            $tenant->setConnection('landlord');
            $tenant->setTable('tenants');
            
            // Map the fields - Spatie expects 'id', 'name', 'domain', 'database'
            $tenant->id = $landlordTenant->tenant_id;
            $tenant->name = $landlordTenant->tenant_name ?? $landlordTenant->subdomain ?? '';
            $tenant->domain = $landlordTenant->domain;
            $tenant->database = $landlordTenant->database ?? '';
            
            // Mark as existing so it doesn't try to save
            $tenant->exists = true;
            $tenant->wasRecentlyCreated = false;
        }

        if ($tenant) {
            Log::info('TenantFinder: Successfully found/created tenant', [
                'tenant_id' => $tenant->id ?? $tenant->tenant_id ?? 'unknown',
                'domain' => $tenant->domain ?? $landlordTenant->domain,
            ]);
        } else {
            Log::error('TenantFinder: Failed to create Tenant instance', [
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
        // Check if URL contains '/app-admin'
        if (strpos($request->url(), '/app-admin') !== false) {
            return true;
        }

        // Check if domain matches LANDLORD_DOMAIN
        $landlordDomain = env('LANDLORD_DOMAIN', '');
        if ($landlordDomain != '') {
            $domains_list = explode(',', preg_replace('/\s+/', '', $landlordDomain));
            $host = str_replace('www.', '', $request->getHost());
            if (in_array($host, $domains_list)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if this is a frontend request
     */
    private function isFrontendRequest($request): bool
    {
        $frontendDomain = env('FRONTEND_DOMAIN', '');
        if ($frontendDomain != '') {
            $host = str_replace('www.', '', $request->getHost());
            if ($host == trim(strtolower($frontendDomain))) {
                return true;
            }
        }

        return false;
    }
}

