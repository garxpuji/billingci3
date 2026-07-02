<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Odp extends Model
{
    use HasFactory;

    protected $table = 'odps'; // ODP = Optical Distribution Point

    protected $fillable = [
        'name',
        'code',
        'odc_id',
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
     * Get the ODC that owns the ODP
     */
    public function odc(): BelongsTo
    {
        return $this->belongsTo(Odc::class);
    }

    /**
     * Get customers connected to this ODP
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'odp_id');
    }

    /**
     * Calculate available ports
     */
    public function getAvailablePortsAttribute(): int
    {
        return $this->capacity - $this->used_ports;
    }

    /**
     * Check if ODP has available ports
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
     * Scope to get only active ODPs
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

        static::creating(function ($odp) {
            if (empty($odp->code)) {
                $odp->code = 'ODP-' . strtoupper(\Str::random(6));
            }
        });
    }
}
