<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SpecieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('species')->insert([
            [
                "name" => "Panthera leo",
                "genu_id" => 1,
            ],
            [
                "name" => "Ailuropoda melanoleuca",
                "genu_id" => 2,
            ],
            [
                "name" => "Danaus plexippus",
                "genu_id" => 3,
            ],
            [
                "name" => "Ophiophagus hannah",
                "genu_id" => 4,
            ],
            [
                "name" => "Aptenodytes forsteri",
                "genu_id" => 5,
            ],
            [
                "name" => "Quercus robur",
                "genu_id" => 6,
            ],
            [
                "name" => "Helianthus annuus",
                "genu_id" => 7,
            ],
            [
                "name" => "Dionaea muscipula",
                "genu_id" => 8,
            ],
            [
                "name" => "Nymphaea alba",
                "genu_id" => 9,
            ],
            [
                "name" => "Aloe vera",
                "genu_id" => 10,
            ],
        ]);
    }
}
