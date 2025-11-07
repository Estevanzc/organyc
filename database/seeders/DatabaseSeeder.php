<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'estevan.zimermann@gmail.com',
            'password' => 'admin',
        ]);
        $this->call([
            Animal_suggestionSeeder::class,
            Plant_suggestionSeeder::class,
            KingdomSeeder::class,
            PhylumSeeder::class,
            ClassSeeder::class,
            OrderSeeder::class,
            FamilySeeder::class,
            GenuSeeder::class,
            SpecieSeeder::class,
            AnimalSeeder::class,
            PlantSeeder::class,
        ]);
    }
}
