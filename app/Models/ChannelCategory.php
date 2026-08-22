<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChannelCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'flag',
        'channels_count',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
