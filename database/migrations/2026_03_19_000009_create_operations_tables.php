<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cycle_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reference', 30)->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'pending_review', 'approved', 'canceled'])->default('scheduled');
            $table->date('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });

        Schema::create('cycle_count_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cycle_count_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('expected_qty', 14, 2);
            $table->decimal('counted_qty', 14, 2)->nullable();
            $table->decimal('variance', 14, 2)->nullable();    // counted - expected
            $table->boolean('adjustment_created')->default(false);
            $table->text('notes')->nullable();
        });

        Schema::create('pick_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->restrictOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reference', 30)->nullable();
            $table->enum('type', ['single', 'batch', 'wave'])->default('single');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'canceled'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
        });

        Schema::create('pick_list_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pick_list_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('qty_requested', 14, 2);
            $table->decimal('qty_picked', 14, 2)->default(0);
            $table->integer('sort_order')->default(0);  // Orden optimizado de recorrido
            $table->boolean('is_picked')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pick_list_lines');
        Schema::dropIfExists('pick_lists');
        Schema::dropIfExists('cycle_count_lines');
        Schema::dropIfExists('cycle_counts');
    }
};
