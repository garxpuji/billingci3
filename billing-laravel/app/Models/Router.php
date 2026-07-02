<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Router extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'username',
        'password',
        'port',
        'coverage_id',
        'status', // active, inactive
        'notes',
        'api_port',
        'ros_version',
    ];

    protected $casts = [
        'status' => 'boolean',
        'port' => 'integer',
        'api_port' => 'integer',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the coverage that owns the router
     */
    public function coverage(): BelongsTo
    {
        return $this->belongsTo(Coverage::class);
    }

    /**
     * Get customers using this router
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Scope to get only active routers
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Get connection config for Mikrotik API
     */
    public function getConnectionConfig(): array
    {
        return [
            'host' => $this->ip_address,
            'user' => $this->username,
            'pass' => $this->password,
            'port' => $this->api_port ?? 8728,
        ];
    }
}
