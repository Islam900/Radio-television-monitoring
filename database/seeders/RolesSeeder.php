<?php

namespace Database\Seeders;

use App\Models\Stations;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Administrator',
            'Moderator'
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web'
            ]);
        }

        $permissions = [
            'Məntəqələr',
            'Məlumatlar',
            'İstifadəçilər',
            'Bütün məntəqələr',
            'Yeni məntəqə yaratmaq',
            'Tezliklər',
            'Proqram adları',
            'İstiqamətlər',
            'Yayım yerləri',
            'Proqram dilləri',
            'Məntəqələr üzrə istifadəçilər',
            'Sistem istifadəçiləri',
            'Vəzifələr',
        ];

        $stations = Stations::pluck('station_name')->toArray();
        foreach ($stations as $station) {
            $permissions[] = $station;
        }

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }

        $permissions = Permission::pluck('id', 'id')->all();

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            $role->syncPermissions($permissions);
        }

        $user = User::where('name_surname', 'Şıxıyev Cavid Çapar')->first();
        $user->assignRole(['Administrator']);
    }

}
