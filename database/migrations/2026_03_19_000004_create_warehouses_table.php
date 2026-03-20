<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->enum('rotation_strategy', ['fifo', 'fefo', 'manual'])->default('fifo');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->unique(['tenant_id', 'code']);
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30);                 // Código completo: A-01-03-B
            $table->string('zone')->nullable();          // Zona: A, B, Refrigerados
            $table->string('aisle')->nullable();         // Pasillo: 01
            $table->string('shelf')->nullable();         // Estante: 03
            $table->string('bin')->nullable();           // Bin: B
            $table->enum('type', ['storage', 'receiving', 'shipping', 'quarantine', 'staging'])->default('storage');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['warehouse_id', 'code']);
            $table->index(['tenant_id', 'warehouse_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
        Schema::dropIfExists('warehouses');
    }
};
