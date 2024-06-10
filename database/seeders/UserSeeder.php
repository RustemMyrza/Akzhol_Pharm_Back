<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=UserSeeder
     *
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Толеби',
                'last_name' => 'Жаксыбай',
                'email' => 'tolebizaksybaj@gmail.com',
                'password' => 'asdasd',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => 'developer'
            ],
            [
                'first_name' => 'Админ',
                'last_name' => 'Админ',
                'email' => 'admin@demo.kz',
                'password' => 'admin',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => 'admin'
            ],
            [
                'first_name' => 'Менеджер',
                'last_name' => 'Менеджер',
                'email' => 'manager@demo.kz',
                'password' => 'manager',
                'email_verified_at' => date('Y-m-d H:i:s'),
                'role' => 'manager'
            ],
        ];

        foreach ($users as $user) {
            User::query()
                ->create([
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'email_verified_at' => $user['email_verified_at'],
                ])
                ->assignRole($user['role']);
            unset($user);
        }

//        User::factory()->count(100)->create();
    }
}
