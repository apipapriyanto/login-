<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat role admin
        $adminRole = new Role();
        $adminRole->name = "admin";
        $adminRole->display_name = "Admin";
        $adminRole->save();

        // Membuat role user
        $userRole = new Role();
        $userRole->name = "user";
        $userRole->display_name = "User";
        $userRole->save();
        

        // Membuat role admin
        $admin = new User();
        $admin->name = 'Admin Larapus';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('rahasia');
        $admin->save();
        $admin->attachRole($adminRole);

        $user = new User();
        $user->name = 'Apip';
        $user->email = 'apip@gmail.com';
        $user->password = bcrypt('rahasia');
        $user->save();
        $user->attachRole($userRole);
    }
}
