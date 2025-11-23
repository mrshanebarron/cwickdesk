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
        Schema::create('activity_log', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable(); // Optional grouping (e.g., 'tickets', 'assets')
            $table->text('description'); // Human-readable description of what happened
            $table->string('event'); // created, updated, deleted, etc.

            // Subject: The model that was affected
            $table->nullableMorphs('subject');

            // Causer: The user who performed the action
            $table->nullableMorphs('causer');

            // Properties: Store old/new values as JSON
            $table->json('properties')->nullable();

            // Batch UUID: Group related changes together
            $table->uuid('batch_uuid')->nullable();

            // Additional context
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // Indexes for better performance (morphs already create their own indexes)
            $table->index('log_name');
            $table->index('event');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
