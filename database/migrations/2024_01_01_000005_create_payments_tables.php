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
        // Tabel Payment Methods
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique(); // bca_va, xendit_ewallet, midtrans_qris, etc
            $table->enum('type', ['bank_transfer', 'e_wallet', 'qris', 'virtual_account', 'retail'])->default('bank_transfer');
            $table->string('gateway')->nullable(); // xendit, midtrans, tripay, duitku, manual
            $table->text('configuration')->nullable(); // JSON config for gateway
            $table->decimal('admin_fee', 12, 2)->default(0);
            $table->enum('fee_type', ['fixed', 'percentage'])->default('fixed');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Tabel Payments / Incomes
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number')->unique();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->nullOnDelete();
            $table->decimal('amount', 12, 2)->default(0);
            $table->decimal('admin_fee', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->date('payment_date');
            $table->string('payment_gateway')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('va_number')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->text('callback_data')->nullable(); // JSON data from payment gateway callback
            $table->timestamp('paid_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Who recorded this payment
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('payment_number');
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_methods');
    }
};
