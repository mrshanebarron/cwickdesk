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
        Schema::create('slack_integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->string('team_id'); // Slack team ID
            $table->string('team_name');
            $table->string('channel_id')->nullable(); // Default channel for notifications
            $table->string('channel_name')->nullable();
            $table->text('access_token'); // Encrypted OAuth token
            $table->text('bot_token')->nullable(); // Bot user OAuth token
            $table->string('webhook_url')->nullable(); // Incoming webhook URL
            $table->json('scopes')->nullable(); // Granted OAuth scopes
            $table->boolean('active')->default(true);
            $table->json('notification_events')->nullable(); // Which events to notify about
            $table->timestamps();

            $table->unique(['tenant_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slack_integrations');
    }
};
