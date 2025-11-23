<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'color' => '#10b981', 'sort_order' => 1, 'is_default' => false],
            ['name' => 'Normal', 'color' => '#3b82f6', 'sort_order' => 2, 'is_default' => true],
            ['name' => 'High', 'color' => '#f59e0b', 'sort_order' => 3, 'is_default' => false],
            ['name' => 'Urgent', 'color' => '#ef4444', 'sort_order' => 4, 'is_default' => false],
        ];

        foreach ($priorities as $priority) {
            \App\Models\TicketPriority::create($priority);
        }
    }
}
