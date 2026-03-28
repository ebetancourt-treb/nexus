<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatch_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('order_number', 30)->nullable();
            $table->string('customer_name');
            $table->string('customer_reference')->nullable();
            $table->enum('status', ['draft', 'reserved', 'picking', 'picked', 'dispatched', 'canceled'])->default('draft');
            $table->text('notes')->nullable();
            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('picking_started_at')->nullable();
            $table->timestamp('picked_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'customer_name']);
        });

        Schema::create('dispatch_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dispatch_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('quantity_requested', 12, 2);
            $table->decimal('quantity_picked', 12, 2)->default(0);
            $table->boolean('is_picked')->default(false);
            $table->string('location_note')->nullable();
            $table->timestamps();

            $table->index('dispatch_order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatch_order_lines');
        Schema::dropIfExists('dispatch_orders');
    }
};
