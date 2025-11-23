<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'New', 'color' => '#6366f1', 'sort_order' => 1, 'is_default' => true, 'is_closed' => false],
            ['name' => 'Open', 'color' => '#3b82f6', 'sort_order' => 2, 'is_default' => false, 'is_closed' => false],
            ['name' => 'In Progress', 'color' => '#f59e0b', 'sort_order' => 3, 'is_default' => false, 'is_closed' => false],
            ['name' => 'Pending User', 'color' => '#8b5cf6', 'sort_order' => 4, 'is_default' => false, 'is_closed' => false],
            ['name' => 'Pending Vendor', 'color' => '#a855f7', 'sort_order' => 5, 'is_default' => false, 'is_closed' => false],
            ['name' => 'Resolved', 'color' => '#10b981', 'sort_order' => 6, 'is_default' => false, 'is_closed' => true],
            ['name' => 'Closed', 'color' => '#6b7280', 'sort_order' => 7, 'is_default' => false, 'is_closed' => true],
        ];

        foreach ($statuses as $status) {
            \App\Models\TicketStatus::create($status);
        }
    }
}
