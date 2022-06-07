<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        $user = app(User::class);
        $user->username = 'admin';
        $user->email = 'admin@skprods.ru';
        $user->password = Hash::make('admin');
        $user->first_name = 'Admin';
        $user->last_name = 'Adminus';
        $user->save();
        $user->assignRole('admin');
    }
}
