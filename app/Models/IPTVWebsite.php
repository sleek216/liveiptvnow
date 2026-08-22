<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IPTVWebsite extends Model
{
    protected $table = 'iptv_websites';

    protected $fillable = [
        'name', 'base_url', 'api_orders_url', 'api_packages_url',
        'api_key', 'api_secret', 'auth_type', 'webhook_secret',
        'status', 'last_sync_at'
    ];

    protected $casts = [
        'status' => 'boolean',
        'last_sync_at' => 'datetime',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(IPTVOrder::class, 'iptv_website_id');
    }

    public function packageMappings(): HasMany
    {
        return $this->hasMany(IPTVPackageMapping::class, 'iptv_website_id');
    }
}
