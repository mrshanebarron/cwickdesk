<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptops', 'description' => 'Portable computers', 'icon' => 'heroicon-o-computer-desktop', 'sort_order' => 1],
            ['name' => 'Desktops', 'description' => 'Desktop computers', 'icon' => 'heroicon-o-computer-desktop', 'sort_order' => 2],
            ['name' => 'Monitors', 'description' => 'Display screens', 'icon' => 'heroicon-o-tv', 'sort_order' => 3],
            ['name' => 'Printers', 'description' => 'Printing devices', 'icon' => 'heroicon-o-printer', 'sort_order' => 4],
            ['name' => 'Phones', 'description' => 'Desk phones and mobile devices', 'icon' => 'heroicon-o-phone', 'sort_order' => 5],
            ['name' => 'Network Equipment', 'description' => 'Routers, switches, access points', 'icon' => 'heroicon-o-signal', 'sort_order' => 6],
            ['name' => 'Servers', 'description' => 'Server hardware', 'icon' => 'heroicon-o-server', 'sort_order' => 7],
            ['name' => 'Software Licenses', 'description' => 'Software licenses and subscriptions', 'icon' => 'heroicon-o-key', 'sort_order' => 8],
            ['name' => 'Peripherals', 'description' => 'Keyboards, mice, webcams, etc.', 'icon' => 'heroicon-o-device-phone-mobile', 'sort_order' => 9],
        ];

        foreach ($categories as $category) {
            \App\Models\AssetCategory::create($category);
        }
    }
}
