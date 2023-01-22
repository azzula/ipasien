<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@ipasien.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('admin');

        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@ipasien.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('operator');
    }
}
