<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_number',
        'invoice_id',
        'customer_id',
        'payment_method_id',
        'amount',
        'payment_date',
        'payment_gateway',
        'transaction_id',
        'va_number',
        'status',
        'notes',
        'callback_data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'decimal:2',
            'callback_data' => 'array',
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (!$payment->payment_number) {
                $payment->payment_number = self::generatePaymentNumber();
            }
        });

        // Update invoice status when payment is successful
        static::updated(function ($payment) {
            if ($payment->wasChanged('status') && $payment->status === self::STATUS_SUCCESS) {
                $payment->invoice->markAsPaid([
                    'payment_date' => $payment->payment_date,
                    'payment_method' => $payment->paymentMethod?->name ?? $payment->payment_gateway,
                    'payment_gateway' => $payment->payment_gateway,
                    'transaction_id' => $payment->transaction_id,
                ]);
            }
        });
    }

    /**
     * Generate unique payment number
     */
    public static function generatePaymentNumber(): string
    {
        $prefix = 'PAY-' . date('Ymd');
        $lastPayment = self::where('payment_number', 'like', "$prefix%")
            ->orderBy('payment_number', 'desc')
            ->first();

        if ($lastPayment) {
            $lastNumber = (int) substr($lastPayment->payment_number, -5);
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '00001';
        }

        return $prefix . $newNumber;
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', self::STATUS_SUCCESS);
    }

    public function scopeFailed($query)
    {
        return $query->where('status', self::STATUS_FAILED);
    }

    public function scopeByGateway($query, $gateway)
    {
        return $query->where('payment_gateway', $gateway);
    }

    /**
     * Relationships
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Process webhook callback
     */
    public function processCallback(array $data): void
    {
        $this->update([
            'callback_data' => $data,
        ]);

        // Determine status from callback
        $status = $this->determineStatusFromCallback($data);

        if ($status !== $this->status) {
            $this->update(['status' => $status]);
        }
    }

    /**
     * Determine payment status from callback data
     * This should be overridden by specific gateway implementations
     */
    protected function determineStatusFromCallback(array $data): string
    {
        // Default implementation - should be customized per gateway
        return self::STATUS_PENDING;
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * Check if payment is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }
}
