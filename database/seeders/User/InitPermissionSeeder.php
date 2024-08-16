<?php

namespace Database\Seeders\User;


use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;

class InitPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin_permission = Permission::where('role','admin')->first();

        if(!$admin_permission) {
            Permission::create([
                'role'              => 'admin',
                'rw_own_customer'   => true,
                'rw_own_deals'      => true,
                'rw_own_reports'    => true,
                'rw_customer'       => true,
                'rw_deals'          => true,
                'rw_reports'        => true,
                'rw_options'        => true,
                'rw_parameters'     => true,
                'rw_users'          => true,
            ]);
        }


        $top_manager_permittion = Permission::where('role','top_manager')->first();

        if(!$top_manager_permittion) {
            Permission::create([
                'role'              => 'top_manager',
                'rw_own_customer'   => true,
                'rw_own_deals'      => true,
                'rw_own_reports'    => true,
                'rw_customer'       => true,
                'rw_reports'        => true,
                'rw_deals'          => true,
                'rw_reports'        => true,
                'rw_options'        => false,
                'rw_parameters'     => false,
                'rw_users'          => false,
            ]);
        }

        $manager_permittion = Permission::where('role','manager')->first();

        if(!$manager_permittion) {
            Permission::create([
                'role'              => 'manager',
                'rw_own_customer'   => true,
                'rw_own_deals'      => true,
                'rw_own_reports'    => true,
                'rw_customer'       => false,
                'rw_reports'        => false,
                'rw_deals'          => false,
                'rw_reports'        => false,
                'rw_options'        => false,
                'rw_parameters'     => false,
                'rw_users'          => false,
            ]);
        }

        $admin_permission = Permission::where('role','admin')->first();

        if($admin_permission) {

            $user = User::where('email','ditrix2006@gmail.com')->first();

            if(!$user) {
                User::create([
                    'permission_id' => $admin_permission->id,
                    'name'          => 'Admin',
                    'email'         => 'ditrix2006@gmail.com',
                    'phone'         => '',
                    'password'      => Hash::make('password'),
                ]);
            } else {

                $user->update(['permission_id' => $admin_permission->id]);
            }
        }

    }
}
