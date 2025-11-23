<?php

namespace Database\Seeders;

use App\Models\KbCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KbCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Account & Access',
                'description' => 'Help with account creation, passwords, login issues, and access permissions',
                'icon' => 'heroicon-o-user-circle',
                'sort_order' => 1,
            ],
            [
                'name' => 'Email & Communication',
                'description' => 'Email setup, troubleshooting, spam filtering, and communication tools',
                'icon' => 'heroicon-o-envelope',
                'sort_order' => 2,
            ],
            [
                'name' => 'Network & Connectivity',
                'description' => 'WiFi issues, VPN setup, network troubleshooting, and internet connectivity',
                'icon' => 'heroicon-o-wifi',
                'sort_order' => 3,
            ],
            [
                'name' => 'Hardware & Devices',
                'description' => 'Computer hardware, monitors, keyboards, mice, and peripheral devices',
                'icon' => 'heroicon-o-computer-desktop',
                'sort_order' => 4,
            ],
            [
                'name' => 'Software & Applications',
                'description' => 'Software installation, updates, licensing, and application support',
                'icon' => 'heroicon-o-squares-2x2',
                'sort_order' => 5,
            ],
            [
                'name' => 'Passwords & Security',
                'description' => 'Password management, two-factor authentication, and security best practices',
                'icon' => 'heroicon-o-lock-closed',
                'sort_order' => 6,
            ],
            [
                'name' => 'Printers & Scanners',
                'description' => 'Printer setup, troubleshooting, scanning, and print management',
                'icon' => 'heroicon-o-printer',
                'sort_order' => 7,
            ],
            [
                'name' => 'Mobile Devices',
                'description' => 'Smartphones, tablets, mobile email, and device management',
                'icon' => 'heroicon-o-device-phone-mobile',
                'sort_order' => 8,
            ],
            [
                'name' => 'Remote Access',
                'description' => 'VPN, remote desktop, working from home, and remote connectivity',
                'icon' => 'heroicon-o-globe-alt',
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            KbCategory::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'sort_order' => $category['sort_order'],
                'is_visible' => true,
            ]);

            $this->command->info("✓ Created category: {$category['name']}");
        }

        $this->command->info("✅ Created " . count($categories) . " KB categories");
    }
}
