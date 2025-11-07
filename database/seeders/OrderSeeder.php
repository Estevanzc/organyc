<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('orders')->insert([
            [
                "name" => "Carnivora",
                "class_id" => 1,
            ],
            [
                "name" => "Lepidoptera",
                "class_id" => 2,
            ],
            [
                "name" => "Squamata",
                "class_id" => 3,
            ],
            [
                "name" => "Sphenisciformes",
                "class_id" => 4,
            ],
            [
                "name" => "Fagales",
                "class_id" => 5,
            ],
            [
                "name" => "Asterales",
                "class_id" => 5,
            ],
            [
                "name" => "Caryophyllales",
                "class_id" => 5,
            ],
            [
                "name" => "Nymphaeales",
                "class_id" => 5,
            ],
            [
                "name" => "Asparagales",
                "class_id" => 6,
            ],
        ]);
    }
}
