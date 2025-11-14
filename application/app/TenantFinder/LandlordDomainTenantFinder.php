<?php

namespace App\TenantFinder;

use Spatie\Multitenancy\TenantFinder\TenantFinder;
use Spatie\Multitenancy\Models\Tenant;

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

        // Find tenant in landlord database using Spatie Tenant model
        // The tenants are stored in the landlord database
        $tenant = Tenant::on('landlord')
            ->where('domain', $host)
            ->first();

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

