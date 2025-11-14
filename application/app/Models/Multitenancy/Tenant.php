<?php

namespace App\Models\Multitenancy;

use Spatie\Multitenancy\Models\Tenant as SpatieTenant;

/**
 * Custom Tenant model that extends Spatie's Tenant model
 * Only maps the database structure to what Spatie expects
 */
class Tenant extends SpatieTenant
{
    /**
     * The primary key for the model.
     * Your table uses 'tenant_id' instead of 'id'
     */
    protected $primaryKey = 'tenant_id';

    /**
     * Get the name attribute.
     * Spatie expects 'name', but your table has 'tenant_name'
     */
    public function getNameAttribute()
    {
        return $this->attributes['tenant_name'] 
            ?? $this->attributes['subdomain'] 
            ?? $this->attributes['domain'] 
            ?? '';
    }

    /**
     * Set the name attribute.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['tenant_name'] = $value;
    }
}

