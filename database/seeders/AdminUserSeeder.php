<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@sjp.ac.lk',
            'usertype' => 'Admin',
            'password' => bcrypt('123456'),
            'role' => 'Admin'
        ]);
    }
}
