<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Starter, Profesional, Enterprise
            $table->string('slug')->unique();          // starter, profesional, enterprise
            $table->decimal('price_monthly', 10, 2);   // 349.00, 899.00, 2499.00
            $table->decimal('price_yearly', 10, 2);    // 3490.00, 8990.00, 24990.00
            $table->integer('max_warehouses');          // 1, 3, -1 (ilimitado)
            $table->integer('max_skus');                // 1000, -1, -1
            $table->integer('max_users');               // 3, 10, -1
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('plan_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->string('feature_key');             // lots.enabled, transfers.enabled, workflows.configurable, etc.
            $table->boolean('enabled')->default(false);
            $table->unique(['plan_id', 'feature_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_features');
        Schema::dropIfExists('plans');
    }
};
