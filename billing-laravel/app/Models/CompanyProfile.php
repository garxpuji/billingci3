<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'legal_name',
        'npwp',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'website',
        'logo_path',
        'footer_text',
        'invoice_template',
        'tax_rate',
        'currency',
        'timezone',
        'locale',
        'social_media',
        'bank_accounts',
        'terms_conditions',
        'privacy_policy',
    ];

    protected $casts = [
        'tax_rate' => 'decimal:2',
        'social_media' => 'array',
        'bank_accounts' => 'array',
    ];

    /**
     * Get the default company profile (singleton pattern)
     */
    public static function get(): self
    {
        return static::firstOrCreate([], [
            'name' => config('app.name'),
            'currency' => 'IDR',
            'timezone' => 'Asia/Jakarta',
            'locale' => 'id',
            'tax_rate' => 0,
        ]);
    }

    /**
     * Get formatted address
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->province,
            $this->postal_code,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute(): string
    {
        if (!$this->phone) {
            return '';
        }

        // Format Indonesian phone numbers
        if (str_starts_with($this->phone, '0')) {
            return '+62' . substr($this->phone, 1);
        }

        if (!str_starts_with($this->phone, '+')) {
            return '+62' . $this->phone;
        }

        return $this->phone;
    }

    /**
     * Get social media links
     */
    public function getSocialMediaLinks(): array
    {
        return $this->social_media ?? [];
    }

    /**
     * Get bank accounts
     */
    public function getBankAccounts(): array
    {
        return $this->bank_accounts ?? [];
    }

    /**
     * Check if tax is applied
     */
    public function hasTax(): bool
    {
        return $this->tax_rate > 0;
    }

    /**
     * Calculate tax amount
     */
    public function calculateTax(float $amount): float
    {
        return ($amount * $this->tax_rate) / 100;
    }
}
