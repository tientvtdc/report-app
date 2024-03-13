<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $roleSuperAdmin = Role::create(['name' => 'SUPER_ADMIN']);
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456Aa'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $user->assignRole($roleSuperAdmin);

//
//        $user = User::factory()->create([
//            'name' => 'User1',
//            'email' => 'user1@user.com',
//            'password' => Hash::make('123456Aa'),
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);

    }
}
