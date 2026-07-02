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
        // Tabel Coverages (Area Management)
        Schema::create('coverages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('address')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_phone')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel Routers (Mikrotik Configuration)
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->integer('port')->default(8728);
            $table->string('username');
            $table->string('password'); // Should be encrypted in production
            $table->boolean('is_active')->default(true);
            $table->foreignId('coverage_id')->nullable()->constrained('coverages')->cascadeOnDelete();
            $table->timestamps();
        });

        // Tabel ODCs (Optical Distribution Cabinet)
        Schema::create('odcs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('capacity')->default(0);
            $table->integer('used')->default(0);
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->foreignId('coverage_id')->nullable()->constrained('coverages')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabel ODPs (Optical Distribution Point)
        Schema::create('odps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->integer('capacity')->default(0);
            $table->integer('used')->default(0);
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->foreignId('odc_id')->nullable()->constrained('odcs')->nullOnDelete();
            $table->foreignId('coverage_id')->nullable()->constrained('coverages')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odps');
        Schema::dropIfExists('odcs');
        Schema::dropIfExists('routers');
        Schema::dropIfExists('coverages');
    }
};
