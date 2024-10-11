<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'ユーザー1',
                'email' => 'user1@example.com',
                'password' => bcrypt('password'),
                'postal_code' => '111-1111',
                'address' => '東京都品川区',
            ],
            [
                'name' => 'ユーザー2',
                'email' => 'user2@example.com',
                'password' => bcrypt('password'),
                'postal_code' => '222-2222',
                'address' => '東京都渋谷区',

            ],
            [
                'name' => 'ユーザー3',
                'email' => 'user3@example.com',
                'password' => bcrypt('password'),
                'postal_code' => '333-3333',
                'address' => '東京都目黒区',

            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}