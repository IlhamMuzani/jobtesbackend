<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
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
                'nama' => 'Admin',
                'lahir' => '2000-01-01',
                'alamat' => 'Tegal',
                'gender' => 'L',
                'username' => 'admin123',
                'password' => bcrypt('admin123'),               
                'role' => 'admin'
            ],
            [
                'nama' => 'Ilham',
                'lahir' => '2000-02-01',
                'alamat' => 'Tegal',
                'gender' => 'L',
                'username' => 'ilham123',
                'password' => bcrypt('ilham123'),
                'role' => 'member'
            ],

            [
                'nama' => 'Muzani',
                'lahir' => '2000-02-01',
                'alamat' => 'Tegal',
                'gender' => 'L',
                'username' => 'muzani123',
                'password' => bcrypt('muzani123'),
                'role' => 'member'
            ],
        ];

        User::insert($users);
    }
}
