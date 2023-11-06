<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@test.com';
        $user->password = Hash::make('pw');
        $user->save();
        $user = new User();
        $user->name = 'admin';
        $user->email = 'Admin@email.com';
        $user->password = Hash::make('Password');
        $user->save();
    }
}