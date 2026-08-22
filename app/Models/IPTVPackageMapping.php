<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IPTVPackageMapping extends Model
{
    protected $table = 'iptv_package_mappings';

    protected $fillable = [
        'iptv_website_id', 'iptv_provider_id', 'external_package_id',
        'external_package_name', 'provider_package_id',
        'duration_days', 'max_connections', 'bouquet_ids', 'is_trial'
    ];

    protected $casts = [
        'bouquet_ids' => 'json',
        'is_trial' => 'boolean',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(IPTVWebsite::class, 'iptv_website_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(IPTVProvider::class, 'iptv_provider_id');
    }
}
