<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test tenant for local development (subdomain)
        $tenant = Tenant::firstOrCreate(
            ['domain' => 'test.it.test'],
            [
                'name' => 'Test Company',
                'slug' => 'test-company',
                'database' => 'it_landlord',
                'contact_name' => 'Shane Barron',
                'contact_email' => 'shane@test.it.test',
                'plan' => 'enterprise',
                'status' => 'active',
                'is_internal' => true,
                'max_users' => 100,
                'max_tickets_per_month' => null,
                'max_assets' => null,
                'onboarding_completed' => true,
            ]
        );

        $this->command->info('Created test tenant: ' . $tenant->name . ' (' . $tenant->domain . ')');

        // Create test user for this tenant
        $user = User::firstOrCreate(
            ['email' => 'shane@test.it.test'],
            [
                'name' => 'Shane Barron',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ]
        );

        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign admin role
        if (!$user->hasRole('admin')) {
            $user->assignRole('admin');
        }

        $this->command->info('Created test user: ' . $user->email . ' (password: password)');
        $this->command->info('');
        $this->command->info('Add to /etc/hosts:');
        $this->command->info('127.0.0.1 test.it.test');
    }
}
