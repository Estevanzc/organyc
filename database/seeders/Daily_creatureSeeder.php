<?php

namespace Database\Seeders;

use App\Models\Daily_creature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Daily_creatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Daily_creature::factory(1)->create();
    }
}
