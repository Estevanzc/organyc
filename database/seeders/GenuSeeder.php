<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('genus')->insert([
            [
                "name" => "Panthera",
                "family_id" => 1,
            ],
            [
                "name" => "Ailuropoda",
                "family_id" => 2,
            ],
            [
                "name" => "Danaus",
                "family_id" => 3,
            ],
            [
                "name" => "Ophiophagus",
                "family_id" => 4,
            ],
            [
                "name" => "Aptenodytes",
                "family_id" => 5,
            ],
            [
                "name" => "Quercus",
                "family_id" => 6,
            ],
            [
                "name" => "Helianthus",
                "family_id" => 7,
            ],
            [
                "name" => "Dionaea",
                "family_id" => 8,
            ],
            [
                "name" => "Nymphaea",
                "family_id" => 9,
            ],
            [
                "name" => "Aloe",
                "family_id" => 10,
            ],
        ]);
    }
}
