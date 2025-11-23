<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();

            // Company Information
            $table->string('name'); // Company name
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->string('domain')->unique()->nullable(); // Custom domain (optional)
            $table->string('database')->unique(); // Tenant database name

            // Contact Information
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            // Subscription Management
            $table->string('plan')->default('free'); // free, basic, pro, enterprise
            $table->enum('status', ['active', 'trial', 'suspended', 'cancelled'])->default('trial');
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('stripe_id')->nullable()->unique();

            // Branding
            $table->string('logo_url')->nullable();
            $table->string('primary_color')->default('#f59e0b'); // Default amber color
            $table->string('secondary_color')->nullable();

            // Limits and Usage
            $table->unsignedInteger('max_users')->default(5);
            $table->unsignedInteger('max_tickets_per_month')->nullable();
            $table->unsignedInteger('max_assets')->nullable();

            // Meta
            $table->json('settings')->nullable(); // Additional tenant-specific settings
            $table->timestamp('last_active_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tenants');
    }
};
