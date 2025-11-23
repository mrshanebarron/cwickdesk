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
        Schema::table('users', function (Blueprint $table) {
            // SSO fields
            $table->string('sso_provider')->nullable()->after('password'); // 'microsoft', 'google', etc.
            $table->string('sso_id')->nullable()->after('sso_provider'); // External user ID
            $table->json('sso_data')->nullable()->after('sso_id'); // Store profile data
            $table->timestamp('last_sso_sync')->nullable()->after('sso_data');

            // Phone list fields (from Shane's Snipe-IT)
            $table->string('extension')->nullable()->after('last_sso_sync');
            $table->string('cell')->nullable()->after('extension');
            $table->string('direct')->nullable()->after('cell');
            $table->string('building')->nullable()->after('direct');
            $table->string('department')->nullable()->after('building');
            $table->string('area_of_responsibility')->nullable()->after('department');

            // Role/permissions
            $table->boolean('is_admin')->default(false)->after('area_of_responsibility');
            $table->boolean('is_agent')->default(false)->after('is_admin'); // Can handle tickets

            // Make password nullable for SSO-only users
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'sso_provider',
                'sso_id',
                'sso_data',
                'last_sso_sync',
                'extension',
                'cell',
                'direct',
                'building',
                'department',
                'area_of_responsibility',
                'is_admin',
                'is_agent',
            ]);
        });
    }
};
