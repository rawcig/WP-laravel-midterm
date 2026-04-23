<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create all permissions
        $permissions = [
            // Events
            ['name' => 'view-event', 'description' => 'View event details'],
            ['name' => 'create-event', 'description' => 'Create new events'],
            ['name' => 'edit-event', 'description' => 'Edit own events'],
            ['name' => 'delete-event', 'description' => 'Delete own events'],
            
            // Guests
            ['name' => 'view-guests', 'description' => 'View event guests'],
            ['name' => 'create-guest', 'description' => 'Create guest records'],
            ['name' => 'edit-guest', 'description' => 'Edit guest records'],
            ['name' => 'delete-guest', 'description' => 'Delete guest records'],
            ['name' => 'check-in-guest', 'description' => 'Check in guests'],
            
            // Organizers
            ['name' => 'view-organizer', 'description' => 'View organizer details'],
            ['name' => 'create-organizer', 'description' => 'Create organizers'],
            ['name' => 'edit-organizer', 'description' => 'Edit organizers'],
            ['name' => 'delete-organizer', 'description' => 'Delete organizers'],
            
            // Reports
            ['name' => 'view-reports', 'description' => 'View reports and analytics'],
            ['name' => 'export-reports', 'description' => 'Export reports'],
            
            // Users
            ['name' => 'manage-users', 'description' => 'Manage user accounts'],
            ['name' => 'view-users', 'description' => 'View user list'],
        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Get permission IDs
        $permissionIds = DB::table('permissions')->pluck('id', 'name')->toArray();

        // Clear existing role permissions
        DB::table('role_permissions')->truncate();

        // Admin gets all permissions
        $adminPermissions = array_keys($permissionIds);
        foreach ($adminPermissions as $permissionName) {
            DB::table('role_permissions')->insert([
                'role' => 'admin',
                'permission_id' => $permissionIds[$permissionName],
            ]);
        }

        // Organizer permissions
        $organizerPermissions = [
            'view-event', 'create-event', 'edit-event', 'delete-event',
            'view-guests', 'create-guest', 'edit-guest', 'delete-guest', 'check-in-guest',
            'view-organizer', 'view-reports', 'export-reports',
        ];
        foreach ($organizerPermissions as $permissionName) {
            DB::table('role_permissions')->insert([
                'role' => 'organizer',
                'permission_id' => $permissionIds[$permissionName],
            ]);
        }

        // User permissions
        $userPermissions = [
            'view-event', 'view-organizer',
        ];
        foreach ($userPermissions as $permissionName) {
            DB::table('role_permissions')->insert([
                'role' => 'user',
                'permission_id' => $permissionIds[$permissionName],
            ]);
        }
    }
}
