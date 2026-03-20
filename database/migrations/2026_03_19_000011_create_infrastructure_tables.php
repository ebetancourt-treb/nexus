<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->enum('platform', [
                'shopify', 'woocommerce', 'mercadolibre',
                'bind', 'alegra', 'contpaqi',
                'custom_webhook',
            ]);
            $table->json('credentials')->nullable();   // Encriptado via cast en modelo
            $table->json('config')->nullable();         // Mapeos, sync settings, etc.
            $table->enum('status', ['active', 'inactive', 'error'])->default('inactive');
            $table->timestamp('last_synced_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'platform']);
        });

        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name');                      // "ERP Sync", "Shopify Webhook", etc.
            $table->string('token_hash', 64)->unique();  // hash del token, nunca el token en claro
            $table->json('abilities')->nullable();        // ['stock:read', 'movements:write', etc.]
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index('tenant_id');
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('auditable_type');    // App\Models\Product, App\Models\Movement, etc.
            $table->unsignedBigInteger('auditable_id');
            $table->string('event', 20);          // created, updated, deleted, status_changed
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at');

            $table->index(['tenant_id', 'auditable_type', 'auditable_id'], 'audit_logs_auditable_index');
            $table->index(['tenant_id', 'created_at']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // null = notif para todos del tenant
            $table->string('type', 50);           // stock_low, lot_expiring, transfer_received, etc.
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('action_url')->nullable();  // Link a la pantalla relevante
            $table->json('data')->nullable();           // Metadata extra: product_id, warehouse_id, etc.
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'user_id', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('api_tokens');
        Schema::dropIfExists('integrations');
    }
};
