<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    /**
     * Status constants
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_ISOLATED = 'isolated';
    const STATUS_PENDING = 'pending';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'no_services',
        'user_id',
        'coverage_id',
        'router_id',
        'name',
        'no_wa',
        'address',
        'nik',
        'account_username',
        'account_password',
        'pppoe_username',
        'pppoe_password',
        'ip_address',
        'mac_address',
        'status',
        'installation_date',
        'last_payment_date',
        'next_billing_date',
        'grace_period_days',
        'auto_isolir',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'installation_date' => 'date',
            'last_payment_date' => 'date',
            'next_billing_date' => 'date',
            'auto_isolir' => 'boolean',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (!$customer->no_services) {
                $customer->no_services = self::generateNoServices();
            }
        });
    }

    /**
     * Generate unique no_services
     */
    public static function generateNoServices(): string
    {
        $prefix = date('Ymd');
        $lastCustomer = self::where('no_services', 'like', "$prefix%")
            ->orderBy('no_services', 'desc')
            ->first();

        if ($lastCustomer) {
            $lastNumber = (int) substr($lastCustomer->no_services, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeIsolated($query)
    {
        return $query->where('status', self::STATUS_ISOLATED);
    }

    public function scopeWithUnpaidInvoices($query)
    {
        return $query->whereHas('invoices', function ($q) {
            $q->where('status', 'unpaid');
        });
    }

    public function scopeDueDate($query, $days = null)
    {
        $days = $days ?? config('billing.grace_period_default', 3);
        return $query->where('next_billing_date', '<=', now()->addDays($days));
    }

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coverage(): BelongsTo
    {
        return $this->belongsTo(Coverage::class);
    }

    public function router(): BelongsTo
    {
        return $this->belongsTo(Router::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function customerPackages(): HasMany
    {
        return $this->hasMany(CustomerPackage::class);
    }

    public function activePackage(): HasOne
    {
        return $this->hasOne(CustomerPackage::class)->where('status', 'active');
    }

    public function couponUsages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Accessors & Mutators
     */
    public function getIsOverdueAttribute(): bool
    {
        if (!$this->next_billing_date) {
            return false;
        }

        return now()->isAfter($this->next_billing_date);
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        if (!$this->next_billing_date) {
            return null;
        }

        return now()->diffInDays($this->next_billing_date, false);
    }

    /**
     * Check if customer needs isolation
     */
    public function needsIsolation(): bool
    {
        if (!$this->auto_isolir || $this->status === self::STATUS_INACTIVE) {
            return false;
        }

        // Check if has unpaid invoices past due date
        return $this->invoices()
            ->where('status', 'unpaid')
            ->where('due_date', '<', now())
            ->exists();
    }

    /**
     * Format phone number for WhatsApp
     */
    public function getWhatsappNumberAttribute(): ?string
    {
        if (!$this->no_wa) {
            return null;
        }

        // Remove non-numeric characters
        $number = preg_replace('/[^0-9]/', '', $this->no_wa);

        // Add country code if not present
        if (substr($number, 0, 1) === '0') {
            $number = '62' . substr($number, 1);
        } elseif (substr($number, 0, 1) !== '6') {
            $number = '62' . $number;
        }

        return $number;
    }
}
