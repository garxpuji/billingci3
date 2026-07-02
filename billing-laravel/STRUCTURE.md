# 📁 STRUKTUR FOLDER & FILE PROJECT BILLING LARAVEL 13

Struktur folder lengkap untuk project billing system dengan Laravel 13 + Filament PHP.

## 📂 Root Structure
```
billing-laravel/
├── app/                          # Application logic
├── bootstrap/                    # Bootstrap files
├── config/                       # Configuration files
├── database/                     # Migrations, seeders, factories
├── public/                       # Public assets
├── resources/                    # Views, CSS, JS
├── routes/                       # Route definitions
├── storage/                      # Logs, cache, uploads
├── tests/                        # Test files
├── .env.example                  # Environment template
├── composer.json                 # PHP dependencies
└── package.json                  # Node dependencies
```

## 📂 App Structure (Sudah Dibuat)
```
app/
├── Console/Commands/             # Custom artisan commands
│   ├── GenerateMonthlyInvoices.php
│   ├── CheckOverdueInvoices.php
│   └── SyncMikrotikCustomers.php
│
├── Filament/                     # Filament admin panel
│   ├── Resources/                # CRUD resources
│   │   ├── CustomerResource.php
│   │   ├── InvoiceResource.php
│   │   ├── PaymentResource.php
│   │   ├── PackageResource.php
│   │   ├── CoverageResource.php
│   │   ├── RouterResource.php
│   │   ├── CouponResource.php
│   │   └── UserResource.php
│   │
│   └── Widgets/                  # Dashboard widgets
│       ├── RevenueWidget.php
│       ├── UnpaidInvoicesWidget.php
│       ├── ActiveCustomersWidget.php
│       └── OverdueInvoicesWidget.php
│
├── Http/Controllers/             # Controllers
│   ├── Member/                   # Member area controllers
│   │   ├── DashboardController.php
│   │   ├── InvoiceController.php
│   │   └── PaymentController.php
│   │
│   └── Api/                      # API controllers
│       └── Payment/
│           ├── XenditCallbackController.php
│           ├── MidtransCallbackController.php
│           ├── TripayCallbackController.php
│           └── DuitkuCallbackController.php
│
├── Http/Middleware/              # Custom middleware
│   ├── CheckCustomerStatus.php
│   └── RoleMiddleware.php
│
├── Models/                       # Eloquent models (SUDAH DIBUAT)
│   ├── Traits/                   # Model traits
│   │   ├── GeneratesNumbering.php
│   │   └── HasWhatsapp.php
│   │
│   ├── User.php                  # ✓ SUDAH
│   ├── Customer.php              # ✓ SUDAH
│   ├── Invoice.php               # ✓ SUDAH
│   ├── InvoiceDetail.php
│   ├── Payment.php               # ✓ SUDAH
│   ├── PaymentMethod.php
│   ├── Package.php               # ✓ SUDAH
│   ├── CustomerPackage.php
│   ├── Coverage.php
│   ├── Router.php
│   ├── Coupon.php
│   ├── CouponUsage.php
│   ├── Odc.php
│   ├── Odp.php
│   ├── WhatsappSetting.php
│   ├── CompanyProfile.php
│   ├── Expenditure.php
│   ├── ExpenditureCategory.php
│   └── ActivityLog.php
│
├── Rules/                        # Custom validation rules
│   ├── ValidMikrotikUsername.php
│   └── ValidPhoneNumber.php
│
└── Services/                     # Business logic services (SUDAH DIBUAT SEBAGIAN)
    ├── Mikrotik/
    │   └── MikrotikService.php   # ✓ SUDAH
    │
    ├── Whatsapp/
    │   ├── WhatsappService.php
    │   └── Providers/
    │       ├── FonnteProvider.php
    │       └── TwilioProvider.php
    │
    └── Payment/
        ├── PaymentService.php
        └── Gateways/
            ├── XenditGateway.php
            ├── MidtransGateway.php
            ├── TripayGateway.php
            └── DuitkuGateway.php
```

## 📂 Database Structure (Sudah Dibuat Migration)
```
database/
├── migrations/
│   └── 2024_01_01_000001_create_billing_tables.php  # ✓ SUDAH
│
├── factories/
│   ├── CustomerFactory.php
│   ├── InvoiceFactory.php
│   ├── PaymentFactory.php
│   └── PackageFactory.php
│
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    ├── PackageSeeder.php
    ├── PaymentMethodSeeder.php
    └── CoverageSeeder.php
```

## 📂 Config Structure (Sudah Dibuat)
```
config/
├── app.php                       # ✓ SUDAH
├── billing.php                   # ✓ SUDAH - Konfigurasi billing system
├── filament.php                  # Filament config (install later)
└── sanctum.php                   # API token config
```

## 📂 Routes Structure
```
routes/
├── web.php                       # Web routes (Filament admin)
├── member.php                    # Member area routes
├── api.php                       # API routes (payment callbacks)
└── console.php                   # Console routes (scheduler)
```

## 📂 Resources Structure
```
resources/
├── views/
│   ├── layouts/
│   │   ├── member.blade.php
│   │   └── guest.blade.php
│   │
│   ├── member/
│   │   ├── dashboard/
│   │   │   └── index.blade.php
│   │   ├── invoices/
│   │   │   ├── index.blade.php
│   │   │   ├── show.blade.php
│   │   │   └── pay.blade.php
│   │   └── profile/
│   │       └── edit.blade.php
│   │
│   └── vendor/
│       └── filament/             # Filament customizations
│
├── css/
│   └── app.css
│
└── js/
    └── app.js
```

## 📂 Storage Structure
```
storage/
├── app/
│   ├── private/                  # Private files
│   └── public/                   # Public uploads
│       ├── invoices/             # PDF invoices
│       ├── receipts/             # Payment receipts
│       └── company/              # Company logo, etc
│
├── framework/
│   ├── cache/
│   ├── sessions/
│   └── views/
│
└── logs/
    └── laravel.log
```

---

## ✅ FILE YANG SUDAH DIBUAT

### Models (5 files)
1. `app/Models/User.php` - User model dengan Filament integration
2. `app/Models/Customer.php` - Customer model dengan auto-generate no_services
3. `app/Models/Invoice.php` - Invoice model dengan auto status update
4. `app/Models/Payment.php` - Payment model dengan callback handling
5. `app/Models/Package.php` - Package model untuk internet packages

### Services (1 file)
6. `app/Services/Mikrotik/MikrotikService.php` - Mikrotik integration service

### Config (2 files)
7. `config/app.php` - Laravel app configuration
8. `config/billing.php` - Billing system configuration lengkap

### Database (1 file)
9. `database/migrations/2024_01_01_000001_create_billing_tables.php` - Semua tabel billing

### Environment
10. `.env.example` - Template environment variables

---

## 🚀 NEXT STEPS

1. **Install Laravel 13** di folder `billing-laravel`
2. **Install Filament PHP**: `composer require filament/filament:"^3.2"`
3. **Install packages pendukung**:
   - `composer require filament/filament`
   - `composer require spatie/laravel-activitylog`
   - `composer require maatwebsite/excel`
   - `composer require barryvdh/laravel-dompdf`
   - `composer require xendit/xendit-php`
   - `composer require midtrans/midtrans-php`
   - `composer require evilfreelancer/routeros-api-php`

4. **Buat remaining models**: InvoiceDetail, PaymentMethod, Coverage, Router, dll
5. **Buat Filament Resources** untuk setiap model
6. **Setup payment gateway services**
7. **Buat WhatsApp service**
8. **Implementasi member area**
