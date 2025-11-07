<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('classes')->insert([
            [
                "name" => "Mammalia",
                "phylum_id" => 1,
            ],
            [
                "name" => "Insecta",
                "phylum_id" => 2,
            ],
            [
                "name" => "Reptilia",
                "phylum_id" => 1,
            ],
            [
                "name" => "Aves",
                "phylum_id" => 1,
            ],
            [
                "name" => "Magnoliopsida",
                "phylum_id" => 3,
            ],
            [
                "name" => "Liliopsida",
                "phylum_id" => 3,
            ],
        ]);
    }
}
