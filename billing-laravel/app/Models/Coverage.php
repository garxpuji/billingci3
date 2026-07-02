<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'latitude',
        'longitude',
        'radius',
        'status', // active, inactive
        'notes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius' => 'integer', // in meters
        'status' => 'boolean',
    ];

    /**
     * Get customers in this coverage
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get routers associated with this coverage
     */
    public function routers(): HasMany
    {
        return $this->hasMany(Router::class);
    }

    /**
     * Get ODCs in this coverage
     */
    public function odcs(): HasMany
    {
        return $this->hasMany(Odc::class);
    }

    /**
     * Scope to get only active coverages
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Generate slug from name
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($coverage) {
            if (empty($coverage->slug)) {
                $coverage->slug = \Str::slug($coverage->name);
            }
        });
    }
}
