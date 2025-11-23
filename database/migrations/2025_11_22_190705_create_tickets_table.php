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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Auto-generated: IT-2025-001
            $table->string('subject');
            $table->text('description');

            // Relationships
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_to_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('priority_id')->constrained('ticket_priorities');
            $table->foreignId('status_id')->constrained('ticket_statuses');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->onDelete('set null');

            // SLA tracking
            $table->timestamp('due_date')->nullable();
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            // Email integration
            $table->string('email_message_id')->nullable(); // For email-to-ticket
            $table->string('source')->default('web'); // web, email, api

            // Metadata
            $table->boolean('is_internal')->default(false); // Internal IT tickets vs user-facing
            $table->integer('time_spent')->default(0); // Minutes spent on ticket

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('ticket_number');
            $table->index('status_id');
            $table->index('priority_id');
            $table->index('assigned_to_id');
            $table->index('requester_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
