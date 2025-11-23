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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_tag')->unique(); // DF-LT-001, DF-DT-042, etc.
            $table->string('name');
            $table->text('description')->nullable();

            // Categorization
            $table->foreignId('category_id')->constrained('asset_categories');

            // Asset details
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();

            // Assignment
            $table->foreignId('assigned_to_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('location')->nullable(); // Building, office, etc.
            $table->string('department')->nullable();

            // Lifecycle
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_cost', 10, 2)->nullable();
            $table->date('warranty_expires')->nullable();
            $table->string('status')->default('active'); // active, in_storage, retired, broken

            // Metadata
            $table->text('notes')->nullable();
            $table->json('custom_fields')->nullable(); // Flexible storage for category-specific fields

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('asset_tag');
            $table->index('assigned_to_id');
            $table->index('category_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
