<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type', // bank_transfer, ewallet, qris, virtual_account, retail
        'gateway', // xendit, midtrans, tripay, duitku, manual
        'account_number',
        'account_name',
        'bank_name',
        'instructions',
        'status', // active, inactive
        'is_default',
        'sort_order',
        'config', // JSON config for gateway-specific settings
        'notes',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
        'config' => 'array',
    ];

    /**
     * Get payments using this method
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope to get only active payment methods
     */
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order');
    }

    /**
     * Scope to get default payment method
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope to filter by gateway
     */
    public function scopeByGateway($query, string $gateway)
    {
        return $query->where('gateway', $gateway);
    }

    /**
     * Scope to filter by type
     */
    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if payment method is available
     */
    public function isAvailable(): bool
    {
        return $this->status && $this->gateway_configured;
    }

    /**
     * Get gateway configuration
     */
    public function getGatewayConfig(): array
    {
        return $this->config ?? [];
    }

    /**
     * Boot method to ensure only one default
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($method) {
            if ($method->is_default) {
                // Unset other defaults for the same gateway
                static::where('gateway', $method->gateway)
                    ->where('id', '!=', $method->id)
                    ->update(['is_default' => false]);
            }
        });
    }
}
