<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IPTVProvider extends Model
{
    protected $table = 'iptv_providers';

    protected $fillable = [
        'name', 'type', 'api_url', 'username', 'password', 'api_key', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $hidden = [
        'password', 'api_key'
    ];

    public function accounts(): HasMany
    {
        return $this->hasMany(IPTVAccount::class, 'iptv_provider_id');
    }
}
