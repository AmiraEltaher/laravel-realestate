<?php

namespace Database\Seeders;




use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // حذف القديم عشان ما يحصلش تكرار لو عملتي seeder أكتر من مرة
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء Permissions أساسية
        $permissions = [
            'view properties',
            'create properties',
            'edit properties',
            'delete properties',
            'view users',
            'manage users',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // إنشاء Roles وربطهم بالـ Permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $agent = Role::firstOrCreate(['name' => 'agent']);
        $user = Role::firstOrCreate(['name' => 'user']);

        // الـ admin عنده كل الصلاحيات
        $admin->syncPermissions($permissions);

        // الـ agent يقدر يتعامل مع العقارات فقط
        $agent->syncPermissions([
            'view properties',
            'create properties',
            'edit properties',
            'delete properties',
        ]);

        // الـ user يقدر يشوف العقارات بس
        $user->syncPermissions([
            'view properties',
        ]);
    }
}
