<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('families')->insert([
            [
                "name" => "Felidae",
                "order_id" => 1,
            ],
            [
                "name" => "Ursidae",
                "order_id" => 1,
            ],
            [
                "name" => "Nymphalidae",
                "order_id" => 2,
            ],
            [
                "name" => "Elapidae",
                "order_id" => 3,
            ],
            [
                "name" => "Spheniscidae",
                "order_id" => 4,
            ],
            [
                "name" => "Fagaceae",
                "order_id" => 5,
            ],
            [
                "name" => "Asteraceae",
                "order_id" => 6,
            ],
            [
                "name" => "Droseraceae",
                "order_id" => 7,
            ],
            [
                "name" => "Nymphaeaceae",
                "order_id" => 8,
            ],
            [
                "name" => "Asphodelaceae",
                "order_id" => 9,
            ],
        ]);
    }
}
