<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['tenant_id', 'parent_id']);
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('sku', 50);
            $table->string('barcode', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('unit_of_measure', 20)->default('pieza');   // pieza, kg, litro, caja, etc.
            $table->decimal('cost_price', 12, 4)->default(0);
            $table->decimal('sale_price', 12, 4)->default(0);
            $table->integer('reorder_point')->default(0);              // Alerta stock bajo
            $table->integer('reorder_qty')->default(0);                // Cantidad sugerida para reorden
            $table->boolean('track_lots')->default(false);             // ¿Controlar por lotes?
            $table->boolean('track_serials')->default(false);          // ¿Controlar por número de serie?
            $table->decimal('weight', 10, 3)->nullable();              // Peso en kg
            $table->decimal('volume', 10, 3)->nullable();              // Volumen en m³
            $table->boolean('is_active')->default(true);
            $table->json('custom_attributes')->nullable();             // Atributos dinámicos por tenant
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tenant_id', 'sku']);
            $table->index(['tenant_id', 'barcode']);
            $table->index(['tenant_id', 'is_active']);
        });

        Schema::create('product_uom_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('from_uom', 20);        // caja
            $table->string('to_uom', 20);           // pieza
            $table->decimal('factor', 12, 4);        // 12 (1 caja = 12 piezas)
            $table->string('barcode', 50)->nullable(); // Barcode de la caja (diferente al de pieza)

            $table->unique(['product_id', 'from_uom', 'to_uom']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_uom_conversions');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};
