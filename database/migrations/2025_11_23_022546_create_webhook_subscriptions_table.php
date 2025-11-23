<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('webhook_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // User-friendly name (e.g., "Slack notification webhook")
            $table->string('url'); // Webhook endpoint URL
            $table->json('events'); // Array of event names to subscribe to
            $table->string('secret')->nullable(); // Optional webhook secret for signature verification
            $table->boolean('active')->default(true);
            $table->json('headers')->nullable(); // Optional custom headers
            $table->integer('retry_attempts')->default(3);
            $table->timestamp('last_delivered_at')->nullable();
            $table->timestamp('last_failed_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'active']);
        });

        // Webhook delivery log
        Schema::create('webhook_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_subscription_id')->constrained()->cascadeOnDelete();
            $table->string('event'); // Event name (e.g., ticket.created)
            $table->json('payload'); // JSON payload sent
            $table->integer('response_code')->nullable(); // HTTP status code
            $table->text('response_body')->nullable();
            $table->float('duration')->nullable(); // Request duration in seconds
            $table->boolean('success')->default(false);
            $table->integer('attempt')->default(1); // Retry attempt number
            $table->timestamps();

            $table->index(['webhook_subscription_id', 'created_at']);
            $table->index(['success', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_deliveries');
        Schema::dropIfExists('webhook_subscriptions');
    }
};
