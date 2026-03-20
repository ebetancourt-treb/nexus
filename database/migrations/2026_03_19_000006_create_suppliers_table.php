<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 20)->nullable();
            $table->string('contact_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('rfc')->nullable();
            $table->text('address')->nullable();
            $table->integer('lead_time_days')->nullable();  // Días promedio de entrega
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('tenant_id');
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->string('po_number', 30);
            $table->enum('status', ['draft', 'sent', 'partial', 'received', 'canceled'])->default('draft');
            $table->date('expected_at')->nullable();
            $table->date('received_at')->nullable();
            $table->string('currency', 3)->default('MXN');
            $table->decimal('exchange_rate', 12, 6)->default(1.000000);
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('tax', 14, 2)->default(0);
            $table->decimal('total', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'po_number']);
            $table->index(['tenant_id', 'status']);
        });

        Schema::create('po_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->decimal('qty_ordered', 12, 2);
            $table->decimal('qty_received', 12, 2)->default(0);
            $table->decimal('unit_cost', 12, 4);
            $table->decimal('line_total', 14, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('po_lines');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('suppliers');
    }
};
