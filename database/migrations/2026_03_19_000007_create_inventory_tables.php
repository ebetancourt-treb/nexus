<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('lot_number', 50);
            $table->date('manufactured_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->enum('status', ['pending', 'released', 'quarantine', 'expired', 'recalled'])->default('released');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'product_id', 'lot_number']);
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'expires_at']);
        });

        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->nullOnDelete();
            $table->string('serial_number', 100);
            $table->enum('status', ['available', 'reserved', 'sold', 'returned', 'damaged'])->default('available');
            $table->foreignId('warehouse_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['tenant_id', 'product_id', 'serial_number']);
            $table->index(['tenant_id', 'status']);
        });

        Schema::create('stock_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('qty_on_hand', 14, 2)->default(0);
            $table->decimal('qty_reserved', 14, 2)->default(0);
            $table->decimal('qty_available', 14, 2)->default(0); // on_hand - reserved
            $table->enum('status', ['available', 'quarantine', 'damaged', 'expired'])->default('available');
            $table->timestamps();

            $table->unique(['tenant_id', 'product_id', 'warehouse_id', 'location_id', 'lot_id'], 'stock_levels_composite_unique');
            $table->index(['tenant_id', 'warehouse_id']);
            $table->index(['tenant_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_levels');
        Schema::dropIfExists('serial_numbers');
        Schema::dropIfExists('lots');
    }
};
