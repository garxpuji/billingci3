<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users table (extends Laravel default)
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['admin', 'member', 'superadmin'])->default('member')->after('phone');
            $table->boolean('is_active')->default(true)->after('role');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });

        // Coverages - Area coverage
        Schema::create('coverages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Routers - Mikrotik routers
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coverage_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('ip_address');
            $table->integer('port')->default(8728);
            $table->string('username');
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Packages - Internet packages
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['home', 'business', 'dedicated'])->default('home');
            $table->decimal('price', 12, 2);
            $table->integer('bandwidth_upload')->nullable(); // in Mbps
            $table->integer('bandwidth_down')->nullable(); // in Mbps
            $table->integer('validity_days')->default(30);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Customers
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_services')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('coverage_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('router_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('no_wa')->nullable();
            $table->text('address')->nullable();
            $table->string('nik')->nullable();
            $table->string('account_username')->nullable(); // Mikrotik username
            $table->string('account_password')->nullable(); // Mikrotik password
            $table->string('pppoe_username')->nullable();
            $table->string('pppoe_password')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->enum('status', ['active', 'inactive', 'isolated', 'pending'])->default('pending');
            $table->date('installation_date')->nullable();
            $table->date('last_payment_date')->nullable();
            $table->date('next_billing_date')->nullable();
            $table->integer('grace_period_days')->default(3);
            $table->boolean('auto_isolir')->default(true);
            $table->timestamps();
            
            $table->index(['status', 'next_billing_date']);
        });

        // Customer Packages (subscription)
        Schema::create('customer_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->restrictOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // who created
            $table->date('bill_date');
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->decimal('amount', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            $table->enum('status', ['unpaid', 'paid', 'cancelled', 'expired'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_auto_generated')->default(false);
            $table->timestamps();
            
            $table->index(['status', 'due_date']);
            $table->index(['customer_id', 'status']);
        });

        // Invoice Details
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        // Payment Methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', ['bank_transfer', 'e_wallet', 'retail', 'qris'])->default('bank_transfer');
            $table->string('bank_code')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Payments/Incomes
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('va_number')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');
            $table->text('notes')->nullable();
            $table->json('callback_data')->nullable(); // Store webhook data
            $table->timestamps();
            
            $table->index(['status', 'payment_date']);
            $table->index(['invoice_id', 'status']);
        });

        // Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['fixed', 'percentage'])->default('percentage');
            $table->decimal('value', 12, 2);
            $table->decimal('min_purchase', 12, 2)->default(0);
            $table->decimal('max_discount', 12, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Coupon Usage
        Schema::create('coupon_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->decimal('discount_amount', 12, 2);
            $table->timestamps();
            
            $table->unique(['coupon_id', 'customer_id', 'invoice_id']);
        });

        // ODC/ODP - Network Infrastructure
        Schema::create('odcs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('coverage_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('total_ports')->default(0);
            $table->integer('used_ports')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('odc_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('coverage_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->integer('total_ports')->default(0);
            $table->integer('used_ports')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // WhatsApp Settings
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider')->default('fonnte'); // fonnte, twilio, etc
            $table->string('api_url');
            $table->string('api_token');
            $table->boolean('is_active')->default(true);
            $table->json('config')->nullable();
            $table->timestamps();
        });

        // Company Profile
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('brand_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('npwp')->nullable();
            $table->json('social_media')->nullable();
            $table->timestamps();
        });

        // Expenditures
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();
            $table->string('expenditure_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('expenditure_categories')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->date('expenditure_date');
            $table->foreignId('user_id')->constrained(); // who recorded
            $table->string('receipt_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('expenditure_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Activity Logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('log_type'); // login, payment, isolir, etc
            $table->string('loggable_type')->nullable(); // Model type
            $table->unsignedBigInteger('loggable_id')->nullable(); // Model ID
            $table->string('description');
            $table->json('properties')->nullable(); // Old/New values
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['loggable_type', 'loggable_id']);
            $table->index(['user_id', 'created_at']);
        });

        // Jobs queue table
        if (!Schema::hasTable('jobs')) {
            Schema::create('jobs', function (Blueprint $table) {
                $table->id();
                $table->string('queue')->index();
                $table->longText('payload');
                $table->unsignedTinyInteger('attempts');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('created_at');
            });
        }

        // Failed jobs table
        if (!Schema::hasTable('failed_jobs')) {
            Schema::create('failed_jobs', function (Blueprint $table) {
                $table->id();
                $table->string('uuid')->unique();
                $table->text('connection');
                $table->text('queue');
                $table->longText('payload');
                $table->longText('exception');
                $table->timestamp('failed_at')->useCurrent();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('expenditure_categories');
        Schema::dropIfExists('expenditures');
        Schema::dropIfExists('company_profiles');
        Schema::dropIfExists('whatsapp_settings');
        Schema::dropIfExists('odps');
        Schema::dropIfExists('odcs');
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_methods');
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('customer_packages');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('routers');
        Schema::dropIfExists('coverages');
        
        // Remove columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'is_active', 'last_login_at']);
        });
    }
};
