<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'original_price',
        'duration_months',
        'duration_days',
        'duration_label',
        'connections',
        'devices',
        'category',
        'description',
        'is_featured',
        'is_popular',
        'is_active',
        'is_reseller',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'is_reseller' => 'boolean',
    ];

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class)->withPivot('is_included')->withTimestamps();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getDevicesAttribute($value): int
    {
        if ($value && $value > 1) {
            return (int) $value;
        }
        return (int) ($this->connections > 1 ? $this->connections : ($value ?? 1));
    }

    public function getDurationLabelAttribute(): string
    {
        // Use the duration_label field from database if available
        if (!empty($this->attributes['duration_label'])) {
            $label = preg_replace('/[\s\-\/\(\),]*\d+\s*connections?[\)\.]*/i', '', $this->attributes['duration_label']);
            return trim($label);
        }

        // Fallback to duration field with mapping
        return match($this->duration) {
            'trial' => 'Trial',
            '1_month' => '1 Month',
            '3_months' => '3 Months',
            '6_months' => '6 Months',
            '12_months' => '12 Months',
            'lifetime' => 'Lifetime',
            default => $this->duration ?? 'Unknown',
        };
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return null;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByDuration($query, string $duration)
    {
        return $query->where('duration', $duration);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeRegular($query)
    {
        return $query->where('is_reseller', false);
    }

    public function scopeReseller($query)
    {
        return $query->where('is_reseller', true);
    }
}
