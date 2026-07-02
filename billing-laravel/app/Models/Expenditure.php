<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'category', // operational, maintenance, salary, utility, other
        'description',
        'amount',
        'payment_method',
        'reference_number',
        'vendor_name',
        'vendor_contact',
        'status', // paid, pending, cancelled
        'notes',
        'attachment_path',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'status' => 'string',
        'created_by' => 'integer',
    ];

    /**
     * Get the user who created this expenditure
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to get only paid expenditures
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope to get only pending expenditures
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get total amount for a period
     */
    public static function getTotalForPeriod($startDate, $endDate, ?string $category = null): float
    {
        $query = static::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'paid');

        if ($category) {
            $query->where('category', $category);
        }

        return $query->sum('amount');
    }

    /**
     * Get categories list
     */
    public static function getCategories(): array
    {
        return [
            'operational' => 'Operasional',
            'maintenance' => 'Maintenance',
            'salary' => 'Gaji Karyawan',
            'utility' => 'Listrik/Air/Internet',
            'rent' => 'Sewa Tempat',
            'marketing' => 'Marketing',
            'tax' => 'Pajak',
            'other' => 'Lain-lain',
        ];
    }

    /**
     * Boot method
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($expenditure) {
            if (!$expenditure->created_by && auth()->check()) {
                $expenditure->created_by = auth()->id();
            }
        });
    }
}
