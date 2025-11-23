<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Ticket Permissions
        $ticketPermissions = [
            'tickets.view.all',
            'tickets.view.assigned',
            'tickets.view.department',
            'tickets.create',
            'tickets.edit.all',
            'tickets.edit.assigned',
            'tickets.delete',
            'tickets.assign',
            'tickets.close',
            'tickets.reopen',
        ];

        // Asset Permissions
        $assetPermissions = [
            'assets.view',
            'assets.create',
            'assets.edit',
            'assets.delete',
            'assets.checkout',
            'assets.checkin',
        ];

        // KB Permissions
        $kbPermissions = [
            'kb.view.published',
            'kb.view.draft',
            'kb.create',
            'kb.edit',
            'kb.publish',
            'kb.delete',
        ];

        // User Permissions
        $userPermissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'users.manage.roles',
        ];

        // Report Permissions
        $reportPermissions = [
            'reports.view',
            'reports.export',
            'reports.custom',
        ];

        // Settings Permissions
        $settingsPermissions = [
            'settings.manage',
            'billing.manage',
        ];

        // Create all permissions
        $allPermissions = array_merge(
            $ticketPermissions,
            $assetPermissions,
            $kbPermissions,
            $userPermissions,
            $reportPermissions,
            $settingsPermissions
        );

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions

        // Platform Admin - Full access to everything
        $platformAdmin = Role::firstOrCreate(['name' => 'platform_admin', 'guard_name' => 'web']);
        $platformAdmin->syncPermissions(Permission::all());

        // Super Admin (Tenant) - Full tenant access
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $superAdmin->syncPermissions(Permission::all());

        // Admin - Manage everything except billing
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(array_merge(
            $ticketPermissions,
            $assetPermissions,
            $kbPermissions,
            $userPermissions,
            $reportPermissions,
            ['settings.manage']
        ));

        // Agent - IT staff member
        $agent = Role::firstOrCreate(['name' => 'agent', 'guard_name' => 'web']);
        $agent->syncPermissions([
            'tickets.view.all',
            'tickets.view.assigned',
            'tickets.create',
            'tickets.edit.assigned',
            'tickets.assign',
            'tickets.close',
            'tickets.reopen',
            'assets.view',
            'assets.create',
            'assets.edit',
            'assets.checkout',
            'assets.checkin',
            'kb.view.published',
            'kb.view.draft',
            'kb.create',
            'kb.edit',
            'reports.view',
        ]);

        // User - End user (can only create tickets)
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $user->syncPermissions([
            'tickets.view.assigned',
            'tickets.create',
            'kb.view.published',
        ]);

        $this->command->info('✓ Created all permissions and roles');
    }
}
