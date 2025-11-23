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
        Schema::create('ticket_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Template name (e.g., "New Computer Setup")
            $table->string('subject'); // Pre-filled subject
            $table->text('description'); // Pre-filled description
            $table->foreignId('priority_id')->nullable()->constrained('ticket_priorities')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('kb_categories')->onDelete('set null');
            $table->string('icon')->nullable(); // Icon for the template
            $table->string('color')->default('primary'); // Color for the button
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->default(0);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_templates');
    }
};
