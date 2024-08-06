<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData=
        [
            [
            'name'=>'Super_Admin',
            'email'=>'superadmin@gmail.com',
            'role'=>'Super_Admin',
            'password'=>bcrypt('superadmin123')
        ],
        $userData=[
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'role'=>'Admin',
            'password'=>bcrypt('admin123')
        ],$userData=[
            'name'=>'Santri',
            'email'=>'santri@gmail.com',
            'role'=>'santri',
            'password'=>bcrypt('santri123')
        ],
    ];
    foreach ($userData as $key =>$val){
        User::create($val);
    }
    
    }
}
