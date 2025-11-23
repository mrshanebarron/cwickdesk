<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            // Ticket Permissions
            'view_tickets',
            'create_tickets',
            'edit_tickets',
            'delete_tickets',
            'assign_tickets',
            'comment_tickets',
            'view_internal_tickets',

            // Asset Permissions
            'view_assets',
            'create_assets',
            'edit_assets',
            'delete_assets',
            'assign_assets',

            // Knowledge Base Permissions
            'view_kb_articles',
            'create_kb_articles',
            'edit_kb_articles',
            'delete_kb_articles',
            'publish_kb_articles',

            // User Management Permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'manage_roles',

            // Settings Permissions
            'view_settings',
            'edit_settings',
            'manage_priorities',
            'manage_statuses',
            'manage_categories',

            // Reporting Permissions
            'view_reports',
            'export_data',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // Super Admin - Has all permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - Can manage most things except system settings
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view_tickets',
            'create_tickets',
            'edit_tickets',
            'delete_tickets',
            'assign_tickets',
            'comment_tickets',
            'view_internal_tickets',
            'view_assets',
            'create_assets',
            'edit_assets',
            'delete_assets',
            'assign_assets',
            'view_kb_articles',
            'create_kb_articles',
            'edit_kb_articles',
            'delete_kb_articles',
            'publish_kb_articles',
            'view_users',
            'create_users',
            'edit_users',
            'view_reports',
            'export_data',
            'manage_priorities',
            'manage_statuses',
            'manage_categories',
        ]);

        // Agent - IT support staff
        $agent = Role::create(['name' => 'agent']);
        $agent->givePermissionTo([
            'view_tickets',
            'create_tickets',
            'edit_tickets',
            'comment_tickets',
            'view_internal_tickets',
            'view_assets',
            'edit_assets',
            'view_kb_articles',
            'create_kb_articles',
            'edit_kb_articles',
            'view_reports',
        ]);

        // User - Regular employees who can submit tickets
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view_tickets',
            'create_tickets',
            'comment_tickets',
            'view_kb_articles',
        ]);

        // Assign super_admin role to the default admin user
        $adminUser = User::where('email', 'mrshanebarron@gmail.com')->first();
        if ($adminUser) {
            $adminUser->assignRole('super_admin');
            // Keep the is_admin flag for backward compatibility
            $adminUser->is_admin = true;
            $adminUser->is_agent = true;
            $adminUser->save();
        }

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('');
        $this->command->info('Created Roles:');
        $this->command->info('- super_admin (all permissions)');
        $this->command->info('- admin (most permissions)');
        $this->command->info('- agent (IT support staff)');
        $this->command->info('- user (regular employees)');
        $this->command->info('');
        $this->command->info('Total Permissions: ' . count($permissions));
    }
}
