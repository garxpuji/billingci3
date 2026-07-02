<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    /**
     * Category constants
     */
    const CATEGORY_HOME = 'home';
    const CATEGORY_BUSINESS = 'business';
    const CATEGORY_DEDICATED = 'dedicated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'category',
        'price',
        'bandwidth_upload',
        'bandwidth_down',
        'validity_days',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Relationships
     */
    public function customerPackages(): HasMany
    {
        return $this->hasMany(CustomerPackage::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get bandwidth label
     */
    public function getBandwidthLabelAttribute(): string
    {
        if ($this->bandwidth_upload && $this->bandwidth_down) {
            return "{$this->bandwidth_upload}/{$this->bandwidth_down} Mbps";
        }

        return $this->bandwidth_down ? "{$this->bandwidth_down} Mbps" : '-';
    }
}
