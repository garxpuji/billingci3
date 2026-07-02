<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappSetting extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_settings';

    protected $fillable = [
        'provider', // fonnte, wablas, twilio, ultramsg, etc
        'api_key',
        'api_secret',
        'api_url',
        'sender_number',
        'status', // active, inactive
        'is_default',
        'config', // additional provider-specific config
        'notes',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_default' => 'boolean',
        'config' => 'array',
    ];

    protected $hidden = [
        'api_key',
        'api_secret',
    ];

    /**
     * Get the default WhatsApp setting (singleton pattern)
     */
    public static function get(): ?self
    {
        return static::where('is_default', true)
            ->where('status', true)
            ->first()
            ?? static::where('status', true)->first();
    }

    /**
     * Check if WhatsApp is configured
     */
    public function isConfigured(): bool
    {
        return $this->status && !empty($this->api_key);
    }

    /**
     * Send WhatsApp message
     */
    public function sendMessage(string $to, string $message): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        // Format phone number
        $to = $this->formatPhoneNumber($to);

        return match ($this->provider) {
            'fonnte' => $this->sendViaFonnte($to, $message),
            'wablas' => $this->sendViaWablas($to, $message),
            default => false,
        };
    }

    /**
     * Send via Fonnte
     */
    private function sendViaFonnte(string $to, string $message): bool
    {
        $response = \Http::withHeaders([
            'Authorization' => $this->api_key,
        ])->post($this->api_url ?? 'https://api.fonnte.com/send', [
            'target' => $to,
            'message' => $message,
        ]);

        return $response->successful();
    }

    /**
     * Send via Wablas
     */
    private function sendViaWablas(string $to, string $message): bool
    {
        $response = \Http::asForm()->post($this->api_url ?? 'https://solo.wablas.com/api/send-message', [
            'phone' => $to,
            'message' => $message,
            'token' => $this->api_key,
        ]);

        return $response->successful();
    }

    /**
     * Format phone number to international format
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Replace leading 0 with 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        // Add 62 if not starts with it
        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    /**
     * Send invoice reminder
     */
    public function sendInvoiceReminder(Invoice $invoice): bool
    {
        $customer = $invoice->customer;
        $message = view('emails.invoice_reminder', compact('invoice'))->render();

        return $this->sendMessage($customer->no_wa, $message);
    }

    /**
     * Send payment confirmation
     */
    public function sendPaymentConfirmation(Payment $payment): bool
    {
        $invoice = $payment->invoice;
        $customer = $invoice->customer;
        $message = view('emails.payment_confirmation', compact('payment', 'invoice'))->render();

        return $this->sendMessage($customer->no_wa, $message);
    }

    /**
     * Send isolation notification
     */
    public function sendIsolationNotification(Customer $customer): bool
    {
        $message = "Halo {$customer->name},\n\n"
            . "Layanan internet Anda telah diisolir karena belum melakukan pembayaran.\n"
            . "Silakan segera melakukan pembayaran untuk mengaktifkan kembali layanan.\n\n"
            . "Terima kasih.";

        return $this->sendMessage($customer->no_wa, $message);
    }

    /**
     * Boot method to ensure only one default
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($setting) {
            if ($setting->is_default) {
                static::where('id', '!=', $setting->id)
                    ->update(['is_default' => false]);
            }
        });
    }
}
