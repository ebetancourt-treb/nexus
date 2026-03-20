<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_definitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete(); // null = sistema (default)
            $table->string('type', 30);         // receiving, dispatch, transfer, adjustment, cycle_count
            $table->string('name');
            $table->integer('version')->default(1);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_system')->default(false); // true = no editable, template del sistema
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'type', 'is_active']);
        });

        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_definition_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('key', 50);          // identificador programático: scan_barcode, capture_lots, confirm
            $table->integer('sort_order');
            $table->boolean('is_required')->default(true);
            $table->json('validation_rules')->nullable();  // Reglas Laravel: ['quantity' => 'required|numeric|min:1']
            $table->json('ui_config')->nullable();          // Config de renderizado para Blade
            $table->timestamps();

            $table->index('workflow_definition_id');
        });

        Schema::create('step_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_step_id')->constrained()->cascadeOnDelete();
            $table->string('field_key', 50);     // lot_number, expires_at, quantity, location_code
            $table->string('label');
            $table->enum('field_type', [
                'text', 'number', 'date', 'select', 'barcode_scan',
                'textarea', 'checkbox', 'location_picker', 'product_picker',
            ]);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_repeatable')->default(false);  // true = permite N filas (multi-lote)
            $table->json('options')->nullable();    // Para selects: [{value: 'kg', label: 'Kilogramos'}]
            $table->string('default_value')->nullable();
            $table->integer('sort_order')->default(0);

            $table->index('workflow_step_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('step_fields');
        Schema::dropIfExists('workflow_steps');
        Schema::dropIfExists('workflow_definitions');
    }
};
