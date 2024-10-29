<?php

namespace Database\Seeders;

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
        // Buat pengguna dengan email admin@gmail.com dan password admin
        User::create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'), 
            'name' => 'admin'
        ]);
    }
}