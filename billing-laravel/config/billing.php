<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Billing System Configuration
    |--------------------------------------------------------------------------
    */

    // Default grace period in days before isolation
    'grace_period_default' => env('BILLING_GRACE_PERIOD', 3),

    // Auto-generate invoices days before due date
    'invoice_generation_days' => env('INVOICE_GENERATION_DAYS', 5),

    // Invoice number format
    'invoice_number_format' => 'INV-Ymd######',

    // Payment number format
    'payment_number_format' => 'PAY-Ymd######',

    // Customer service number format
    'customer_number_format' => 'Ymd####',

    /*
    |--------------------------------------------------------------------------
    | Mikrotik Configuration
    |--------------------------------------------------------------------------
    */

    'mikrotik' => [
        'default_router' => env('MIKROTIK_DEFAULT_ROUTER'),
        'connection_timeout' => 10,
        'connection_attempts' => 2,
        'default_profile' => env('MIKROTIK_DEFAULT_PROFILE', 'default'),
        
        // Auto isolir settings
        'auto_isolir' => [
            'enabled' => env('MIKROTIK_AUTO_ISOLIR', true),
            'check_time' => '02:00', // Daily check time
            'retry_count' => 3,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Configuration
    |--------------------------------------------------------------------------
    */

    'whatsapp' => [
        'default_provider' => env('WHATSAPP_PROVIDER', 'fonnte'),
        'send_on_invoice_created' => env('WA_SEND_INVOICE', true),
        'send_on_payment_received' => env('WA_SEND_PAYMENT', true),
        'send_before_due_date' => env('WA_SEND_REMINDER', true),
        'reminder_days_before' => env('WA_REMINDER_DAYS', 3),
        'send_on_isolir' => env('WA_SEND_ISOLIR', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Configuration
    |--------------------------------------------------------------------------
    */

    'payment_gateways' => [
        'xendit' => [
            'enabled' => env('XENDIT_ENABLED', false),
            'secret_key' => env('XENDIT_SECRET_KEY'),
            'public_key' => env('XENDIT_PUBLIC_KEY'),
            'webhook_token' => env('XENDIT_WEBHOOK_TOKEN'),
            'callback_url' => env('XENDIT_CALLBACK_URL', '/api/payment/xendit/callback'),
        ],

        'midtrans' => [
            'enabled' => env('MIDTRANS_ENABLED', false),
            'server_key' => env('MIDTRANS_SERVER_KEY'),
            'client_key' => env('MIDTRANS_CLIENT_KEY'),
            'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
            'callback_url' => env('MIDTRANS_CALLBACK_URL', '/api/payment/midtrans/callback'),
        ],

        'tripay' => [
            'enabled' => env('TRIPAY_ENABLED', false),
            'api_key' => env('TRIPAY_API_KEY'),
            'private_key' => env('TRIPAY_PRIVATE_KEY'),
            'merchant_code' => env('TRIPAY_MERCHANT_CODE'),
            'callback_url' => env('TRIPAY_CALLBACK_URL', '/api/payment/tripay/callback'),
        ],

        'duitku' => [
            'enabled' => env('DUITKU_ENABLED', false),
            'api_key' => env('DUITKU_API_KEY'),
            'merchant_code' => env('DUITKU_MERCHANT_CODE'),
            'callback_url' => env('DUITKU_CALLBACK_URL', '/api/payment/duitku/callback'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    */

    'notifications' => [
        // Channels: database, mail, whatsapp, broadcast
        'channels' => ['database', 'whatsapp'],
        
        // Invoice created notification
        'invoice_created' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'database'],
        ],

        // Payment received notification
        'payment_received' => [
            'enabled' => true,
            'channels' => ['whatsapp', 'database', 'mail'],
        ],

        // Due date reminder
        'due_date_reminder' => [
            'enabled' => true,
            'days_before' => [3, 1], // Send reminder 3 days and 1 day before due
            'channels' => ['whatsapp'],
        ],

        // Overdue notification
        'overdue' => [
            'enabled' => true,
            'days_after' => [1, 3, 7], // Send notification 1, 3, 7 days after due
            'channels' => ['whatsapp'],
        ],

        // Isolation warning
        'isolation_warning' => [
            'enabled' => true,
            'hours_before' => 24,
            'channels' => ['whatsapp'],
        ],

        // Isolation executed
        'isolation_executed' => [
            'enabled' => true,
            'channels' => ['whatsapp'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Report Settings
    |--------------------------------------------------------------------------
    */

    'reports' => [
        'default_date_range' => 'current_month',
        'export_format' => ['excel', 'pdf'],
        'logo_path' => 'company/logo.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Settings for Background Jobs
    |--------------------------------------------------------------------------
    */

    'queue' => [
        'isolir_job' => 'isolir',
        'notification_job' => 'notifications',
        'invoice_generation_job' => 'invoices',
    ],

];
