<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default data
        $this->call([
            TicketPrioritySeeder::class,
            TicketStatusSeeder::class,
            AssetCategorySeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class, // Import users from Snipe-IT
            KbCategorySeeder::class, // Create KB categories
            KbArticleSeeder::class, // Create default KB articles
            CannedResponseSeeder::class, // Create default canned responses
        ]);
    }
}
