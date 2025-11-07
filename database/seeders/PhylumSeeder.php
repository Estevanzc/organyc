<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhylumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('phylums')->insert([
            [
                "name" => "Chordata",
                "kingdom_id" => 1,
            ],
            [
                "name" => "Arthropoda",
                "kingdom_id" => 1,
            ],
            [
                "name" => "Tracheophyta",
                "kingdom_id" => 2,
            ],
        ]);
    }
}
