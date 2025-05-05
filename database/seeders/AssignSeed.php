<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);
        $permissions = ['admin.manage', 'advisor.manage', 'professor.manage', 'student.manage', 'secretary.manage'];
        $role = Role::findByName('admin');
    
        foreach ($permissions as $permission) {
            $per = Permission::create(['name' => $permission]);
            // $user->givePermissionTo($per);
            $role->givePermissionTo($per);
        }
    }
}
