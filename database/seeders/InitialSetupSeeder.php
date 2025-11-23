<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InitialSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $platformAdminRole = Role::firstOrCreate(['name' => 'platform_admin', 'guard_name' => 'web']);
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // ===========================================
        // 1. DANIELLE FENCE (INTERNAL - FREE)
        // ===========================================
        $danielleFence = Tenant::create([
            'name' => 'Danielle Fence Company',
            'slug' => 'daniellefence',
            'domain' => 'it.daniellehub.com',
            'database' => 'tenant_daniellefence',

            // Contact
            'contact_name' => 'Shane Barron',
            'contact_email' => 'sbarron@daniellefence.net',

            // Subscription (Internal = Free)
            'plan' => 'enterprise',  // Full features
            'status' => 'active',    // Never expires
            'is_internal' => true,   // NO BILLING

            // Branding
            'primary_color' => '#f59e0b', // Amber

            // Limits (unlimited for internal)
            'max_users' => 999,
            'max_tickets_per_month' => null,
            'max_assets' => null,
        ]);

        $this->command->info('✓ Created Danielle Fence tenant (Internal)');

        // Create Danielle Fence admin user
        $danielleFenceUser = User::create([
            'name' => 'Shane Barron',
            'email' => 'sbarron@daniellefence.net',
            'password' => bcrypt('password'), // Change this!
            'tenant_id' => $danielleFence->id,
        ]);

        $danielleFenceUser->assignRole(['super_admin', 'admin']);
        $this->command->info('✓ Created sbarron@daniellefence.net user');

        // ===========================================
        // 2. PLATFORM SUPER ADMIN USER
        // ===========================================
        $platformAdmin = User::create([
            'name' => 'Shane Barron (Platform Admin)',
            'email' => 'mrshanebarron@gmail.com',
            'password' => bcrypt('password'), // Change this!
            'tenant_id' => null, // No specific tenant - can access all
        ]);

        $platformAdmin->assignRole('platform_admin');
        $this->command->info('✓ Created mrshanebarron@gmail.com (Platform Super Admin)');

        $this->command->info('');
        $this->command->info('==============================================');
        $this->command->info('INITIAL SETUP COMPLETE!');
        $this->command->info('==============================================');
        $this->command->info('');
        $this->command->info('DANIELLE FENCE (Internal - No Billing):');
        $this->command->info('  Domain: it.daniellehub.com');
        $this->command->info('  User: sbarron@daniellefence.net');
        $this->command->info('  Password: password (CHANGE THIS!)');
        $this->command->info('');
        $this->command->info('PLATFORM ADMIN (Manage all tenants):');
        $this->command->info('  Domain: cwick.us');
        $this->command->info('  User: mrshanebarron@gmail.com');
        $this->command->info('  Password: password (CHANGE THIS!)');
        $this->command->info('');
    }
}
