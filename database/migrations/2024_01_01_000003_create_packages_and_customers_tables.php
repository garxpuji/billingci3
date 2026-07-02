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
        // Tabel Packages (Internet Packages)
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('category', ['home', 'business', 'dedicated'])->default('home');
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('speed_upload')->default(0); // in Mbps
            $table->integer('speed_download')->default(0); // in Mbps
            $table->integer('validity_days')->default(30);
            $table->boolean('is_unlimited')->default(true);
            $table->integer('quota_gb')->nullable(); // if not unlimited
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Customers
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_services')->unique();
            $table->string('name');
            $table->string('no_wa');
            $table->text('address');
            $table->foreignId('coverage_id')->nullable()->constrained('coverages')->nullOnDelete();
            $table->foreignId('router_id')->nullable()->constrained('routers')->nullOnDelete();
            $table->foreignId('odc_id')->nullable()->constrained('odcs')->nullOnDelete();
            $table->foreignId('odp_id')->nullable()->constrained('odps')->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('username_pppoe')->nullable();
            $table->string('password_pppoe')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->enum('status', ['active', 'inactive', 'isolir', 'pending'])->default('pending');
            $table->date('installation_date')->nullable();
            $table->date('last_payment_date')->nullable();
            $table->date('next_billing_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('no_services');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('packages');
    }
};
