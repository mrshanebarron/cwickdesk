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
        $tables = [
            'users',
            'tickets',
            'ticket_comments',
            'ticket_attachments',
            'ticket_priorities',
            'ticket_statuses',
            'ticket_templates',
            'assets',
            'asset_categories',
            'kb_articles',
            'kb_categories',
            'kb_article_feedback',
            'canned_responses',
            'activity_log',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->foreignId('tenant_id')
                    ->after('id')
                    ->nullable() // Nullable initially for migration
                    ->constrained('tenants')
                    ->onDelete('cascade');

                $table->index('tenant_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'tickets',
            'ticket_comments',
            'ticket_attachments',
            'ticket_priorities',
            'ticket_statuses',
            'ticket_templates',
            'assets',
            'asset_categories',
            'kb_articles',
            'kb_categories',
            'kb_article_feedback',
            'canned_responses',
            'activity_log',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['tenant_id']);
                $table->dropIndex(['tenant_id']);
                $table->dropColumn('tenant_id');
            });
        }
    }
};
