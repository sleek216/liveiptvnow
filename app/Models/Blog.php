<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'read_time',
        'views',
        'is_featured',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'tutorials' => 'Tutorials',
            'updates' => 'Updates',
            'tips' => 'Tips & Tricks',
            'news' => 'Industry News',
            default => ucfirst($this->category),
        };
    }

    public function getCategoryIconAttribute(): string
    {
        return match ($this->category) {
            'tutorials' => 'ri-graduation-cap-line',
            'updates' => 'ri-notification-3-line',
            'tips' => 'ri-lightbulb-line',
            'news' => 'ri-newspaper-line',
            default => 'ri-article-line',
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'tutorials' => '#8b5cf6', // purple
            'updates' => '#3b82f6',   // blue
            'tips' => '#10b981',      // green
            'news' => '#f59e0b',      // orange
            default => '#6366f1',
        };
    }
}
