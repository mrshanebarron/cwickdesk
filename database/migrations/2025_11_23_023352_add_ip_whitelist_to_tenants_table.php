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
        Schema::table('tenants', function (Blueprint $table) {
            $table->boolean('ip_whitelist_enabled')->default(false)->after('settings');
            $table->json('ip_whitelist')->nullable()->after('ip_whitelist_enabled'); // Array of IPs and CIDR ranges
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn(['ip_whitelist_enabled', 'ip_whitelist']);
        });
    }
};
