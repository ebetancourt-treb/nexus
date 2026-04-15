<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Columnas requeridas por Laravel Cashier en el modelo billable (Tenant)
        Schema::table('tenants', function (Blueprint $table) {
            $table->string('stripe_id')->nullable()->index()->after('settings');
            $table->string('pm_type')->nullable()->after('stripe_id');
            $table->string('pm_last_four', 4)->nullable()->after('pm_type');
            $table->timestamp('trial_ends_at')->nullable()->after('pm_last_four');
        });

        // Agregar stripe_price_id a la tabla plans para mapear plan → precio de Stripe
        Schema::table('plans', function (Blueprint $table) {
            $table->string('stripe_price_id')->nullable()->after('price_yearly');
        });

        // Actualizar los price IDs
        DB::table('plans')->where('slug', 'starter')->update(['stripe_price_id' => 'price_1THq8SIUbAEp9LOQjNIO7ib3']);
        DB::table('plans')->where('slug', 'profesional')->update(['stripe_price_id' => 'price_1THq8QIUbAEp9LOQbBeoPAIQ']);
        DB::table('plans')->where('slug', 'enterprise')->update(['stripe_price_id' => 'price_1THqb2IUbAEp9LOQO5SYo3kX']);
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['stripe_id', 'pm_type', 'pm_last_four', 'trial_ends_at']);
        });

        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('stripe_price_id');
        });
    }
};
