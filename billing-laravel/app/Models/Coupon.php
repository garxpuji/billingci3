<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type', // percentage, fixed
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'status', // active, inactive, expired
        'applicable_packages', // null for all packages
        'notes',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'status' => 'boolean',
        'applicable_packages' => 'array',
    ];

    /**
     * Get invoices that used this coupon
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get applicable packages (if restricted)
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'coupon_package');
    }

    /**
     * Check if coupon is valid
     */
    public function isValid(): bool
    {
        if (!$this->status) {
            return false;
        }

        if ($this->valid_from && $this->valid_from->isFuture()) {
            return false;
        }

        if ($this->valid_until && $this->valid_until->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if coupon can be used for a package
     */
    public function isApplicableToPackage(Package $package): bool
    {
        if (empty($this->applicable_packages)) {
            return true; // Applicable to all packages
        }

        return in_array($package->id, $this->applicable_packages);
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $amount, Package $package = null): float
    {
        if (!$this->isValid()) {
            return 0;
        }

        if ($package && !$this->isApplicableToPackage($package)) {
            return 0;
        }

        if ($amount < $this->min_purchase) {
            return 0;
        }

        $discount = 0;

        if ($this->type === 'percentage') {
            $discount = ($amount * $this->value) / 100;
            
            if ($this->max_discount && $discount > $this->max_discount) {
                $discount = $this->max_discount;
            }
        } else {
            // Fixed discount
            $discount = $this->value;
            
            if ($discount > $amount) {
                $discount = $amount;
            }
        }

        return $discount;
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(int $amount = 1)
    {
        $this->increment('used_count', $amount);
    }

    /**
     * Decrement usage count
     */
    public function decrementUsage(int $amount = 1)
    {
        $this->decrement('used_count', $amount);
    }

    /**
     * Scope to get only active coupons
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

        static::creating(function ($coupon) {
            if (empty($coupon->code)) {
                $coupon->code = strtoupper(\Str::random(8));
            }
        });
    }
}
