<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Coupons
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['fixed', 'percentage'])->default('percentage');
            $table->decimal('value', 12, 2)->default(0);
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Tabel Expenditures (Pengeluaran Operasional)
        Schema::create('expenditures', function (Blueprint $table) {
            $table->id();
            $table->string('expenditure_number')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->date('expenditure_date');
            $table->enum('category', ['operational', 'maintenance', 'salary', 'infrastructure', 'marketing', 'other'])->default('operational');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Who created this
            $table->string('receipt_image')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('expenditure_number');
        });

        // Tabel Company Profiles
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('brand_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('tax_number')->nullable();
            $table->text('bank_info')->nullable(); // JSON with bank details
            $table->text('social_media')->nullable(); // JSON with social media links
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Whatsapp Settings
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->default('fonnte'); // fonnte, wablas, twilio, etc
            $table->string('api_key')->nullable();
            $table->string('api_url')->nullable();
            $table->string('sender_id')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('send_invoice_notification')->default(true);
            $table->boolean('send_payment_confirmation')->default(true);
            $table->boolean('send_isolir_warning')->default(true);
            $table->integer('warning_days_before')->default(3); // Days before due date to send warning
            $table->text('custom_messages')->nullable(); // JSON with custom message templates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
        Schema::dropIfExists('company_profiles');
        Schema::dropIfExists('expenditures');
        Schema::dropIfExists('coupons');
    }
};
