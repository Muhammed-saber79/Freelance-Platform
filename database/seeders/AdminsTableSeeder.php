<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Muhammed Saber Shaaban',
            'email' => 'muhammed.saber385@gmail.com',
            'password' => Hash::make('Password#123'),
            'super_admin' => 1,
            'status' => 'active',
        ]);
    }
}
