<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->enum('type', [
                'receiving',     // Recepción de mercancía
                'dispatch',      // Despacho / salida
                'adjustment',    // Ajuste de inventario
                'transfer_out',  // Salida por transferencia
                'transfer_in',   // Entrada por transferencia
                'return',        // Devolución
                'cycle_count',   // Ajuste por conteo cíclico
            ]);
            $table->string('reference', 50)->nullable();   // PO number, order number, etc.
            $table->text('notes')->nullable();
            $table->enum('status', ['draft', 'confirmed', 'completed', 'canceled'])->default('draft');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'type']);
            $table->index(['tenant_id', 'warehouse_id']);
            $table->index(['tenant_id', 'created_at']);
        });

        Schema::create('movement_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity', 14, 2);              // Positivo = entrada, negativo = salida
            $table->decimal('unit_cost', 12, 4)->nullable();
            $table->string('serial_number', 100)->nullable(); // Para productos con tracking serial
            $table->text('notes')->nullable();

            $table->index('movement_id');
        });

        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('to_warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('out_movement_id')->nullable()->constrained('movements')->nullOnDelete();
            $table->foreignId('in_movement_id')->nullable()->constrained('movements')->nullOnDelete();
            $table->enum('status', ['draft', 'in_transit', 'received', 'canceled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
        Schema::dropIfExists('movement_lines');
        Schema::dropIfExists('movements');
    }
};
