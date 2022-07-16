<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
        	[
        		'email' => 'admin@demo.com'
        	],
        	[
        		'role_id' => 1,
        		'first_name' => 'Admin',
        		'last_name' => 'Demo',
        		'phone' => '971555555555',
        		'password' => Hash::make(123456),
        	]
        );
    }
}
