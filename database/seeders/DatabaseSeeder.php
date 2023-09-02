<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Muhammed Saber',
            'email' => 'muhammed.saber@gmail.com',
            'password' => Hash::make('Password#123')
        ]);

        \App\Models\Category::factory()->create([
            'name' => 'cat_1',
        ]);

        $this->call([
            AdminsTableSeeder::class
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Project::factory(10)->create();
        \App\Models\Admin::factory(10)->create();
    }
}
