<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Product::factory(20)->create();

        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@cellar.com',
            'password' => 'password',
            'is_admin' => "Yes"
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Comum User',
            'email' => 'user@cellar.com',
            'password' => 'password',
            'is_admin' => "No"
        ]);
    }
}
