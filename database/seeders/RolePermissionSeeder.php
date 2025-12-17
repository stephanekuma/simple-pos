<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view_customer',
            'view_any_customer',
            'create_customer',
            'update_customer',
            'restore_customer',
            'restore_any_customer',
            'replicate_customer',
            'reorder_customer',
            'delete_customer',
            'delete_any_customer',
            'force_delete_customer',
            'force_delete_any_customer',
            'view_order',
            'view_any_order',
            'create_order',
            'update_order',
            'restore_order',
            'restore_any_order',
            'replicate_order',
            'reorder_order',
            'delete_order',
            'delete_any_order',
            'force_delete_order',
            'force_delete_any_order',
            'view_product',
            'view_any_product',
            'create_product',
            'update_product',
            'restore_product',
            'restore_any_product',
            'replicate_product',
            'reorder_product',
            'delete_product',
            'delete_any_product',
            'force_delete_product',
            'force_delete_any_product',
            'view_role',
            'view_any_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'restore_user',
            'restore_any_user',
            'replicate_user',
            'reorder_user',
            'delete_user',
            'delete_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'page_Pos',
            'page_Setting',
            'page_FinancialReports',
            'widget_SalesOverview',
            'widget_FinancialReportWidget',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $cashier = Role::firstOrCreate(['name' => 'cashier', 'guard_name' => 'web']);

        // Super admin gets all permissions
        $superAdmin->syncPermissions(Permission::all());

        // Admin permissions (same as super_admin except role management)
        $adminPermissions = Permission::whereNotIn('name', ['create_role', 'delete_role', 'delete_any_role'])->get();
        $admin->syncPermissions($adminPermissions);

        // Cashier permissions
        $cashierPermissions = [
            'view_customer',
            'view_any_customer',
            'create_customer',
            'update_customer',
            'replicate_customer',
            'reorder_customer',
            'view_order',
            'view_any_order',
            'create_order',
            'update_order',
            'view_product',
            'view_any_product',
            'create_product',
            'page_Pos',
        ];
        $cashier->syncPermissions($cashierPermissions);
    }
}
