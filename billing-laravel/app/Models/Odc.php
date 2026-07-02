<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Odc extends Model
{
    use HasFactory;

    protected $table = 'odcs'; // ODC = Optical Distribution Cabinet

    protected $fillable = [
        'name',
        'code',
        'coverage_id',
        'address',
        'latitude',
        'longitude',
        'capacity',
        'used_ports',
        'status', // active, inactive, maintenance
        'notes',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'capacity' => 'integer',
        'used_ports' => 'integer',
        'status' => 'boolean',
    ];

    /**
     * Get the coverage that owns the ODC
     */
    public function coverage(): BelongsTo
    {
        return $this->belongsTo(Coverage::class);
    }

    /**
     * Get customers connected to this ODC
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'odc_id');
    }

    /**
     * Get ODPs under this ODC
     */
    public function odps(): HasMany
    {
        return $this->hasMany(Odp::class);
    }

    /**
     * Calculate available ports
     */
    public function getAvailablePortsAttribute(): int
    {
        return $this->capacity - $this->used_ports;
    }

    /**
     * Check if ODC has available ports
     */
    public function hasAvailablePorts(): bool
    {
        return $this->available_ports > 0;
    }

    /**
     * Increment used ports
     */
    public function incrementUsedPorts(int $amount = 1)
    {
        $this->increment('used_ports', $amount);
    }

    /**
     * Decrement used ports
     */
    public function decrementUsedPorts(int $amount = 1)
    {
        $this->decrement('used_ports', $amount);
    }

    /**
     * Scope to get only active ODCs
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Boot method to auto-generate code
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($odc) {
            if (empty($odc->code)) {
                $odc->code = 'ODC-' . strtoupper(\Str::random(6));
            }
        });
    }
}
