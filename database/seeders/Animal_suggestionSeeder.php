<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Animal_suggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table("animal_suggestions")->insert([
            [
                'common_name' => 'African Elephant',
                'conservation_status' => 'Endangered',
                'weight' => '6000 kg',
                'height' => '3.3 m',
                'length' => '6 m',
                'locale' => 'Sub-Saharan Africa',
                'habitat' => 'Savannas, forests, deserts, and marshes',
                'diet' => 'Herbivore',
                'reproduction' => 'Sexual',
                'life_span' => '60-70 years',
                'color' => 'Gray',
                'danger_level' => 'Dangerous',
                'treatment_necessity' => 'Urgent',
                'prevention' => 'Maintain safe distance, avoid provoking',
                'description' => 'The African elephant is the largest land animal on Earth.',
                'inaturalist_id' => 43662,
                'gbif_id' => 2440946,
                'photo' => 'https://inaturalist-open-data.s3.amazonaws.com/photos/20539855/medium.jpg',
                'kingdom' => 'Animalia',
                'phylum' => 'Chordata',
                'class' => 'Mammalia',
                'order' => 'Proboscidea',
                'family' => 'Elephantidae',
                'genu' => 'Loxodonta',
                'specie' => 'Loxodonta africana',
            ],
            [
                'common_name' => 'Bald Eagle',
                'conservation_status' => 'Least Concern',
                'weight' => '6.3 kg',
                'height' => '90 cm',
                'length' => '70-102 cm',
                'locale' => 'North America',
                'habitat' => 'Near large bodies of open water',
                'diet' => 'Carnivore',
                'reproduction' => 'Sexual',
                'life_span' => '20-30 years',
                'color' => 'Brown body with white head and tail',
                'danger_level' => 'Mild',
                'treatment_necessity' => 'Self-care',
                'prevention' => 'Avoid disturbing nests',
                'description' => 'The bald eagle is a bird of prey found in North America and the national bird of the USA.',
                'inaturalist_id' => 5267,
                'gbif_id' => 2480499,
                'photo' => 'https://inaturalist-open-data.s3.amazonaws.com/photos/20539855/medium.jpg',
                'kingdom' => 'Animalia',
                'phylum' => 'Chordata',
                'class' => 'Aves',
                'order' => 'Accipitriformes',
                'family' => 'Accipitridae',
                'genu' => 'Haliaeetus',
                'specie' => 'Haliaeetus leucocephalus',
            ],
            [
                'common_name' => 'Poison Dart Frog',
                'conservation_status' => 'Least Concern',
                'weight' => '2 g',
                'height' => '2.5 cm',
                'length' => '3-5 cm',
                'locale' => 'Central and South America',
                'habitat' => 'Rainforests',
                'diet' => 'Insectivore',
                'reproduction' => 'Sexual',
                'life_span' => '4-6 years',
                'color' => 'Bright blue with black spots',
                'danger_level' => 'Extreme',
                'treatment_necessity' => 'Critical',
                'prevention' => 'Avoid direct contact with skin',
                'description' => 'Poison dart frogs are known for their brightly colored skin and toxicity.',
                'inaturalist_id' => 27645,
                'gbif_id' => 2426317,
                'photo' => 'https://inaturalist-open-data.s3.amazonaws.com/photos/20539855/medium.jpg',
                'kingdom' => 'Animalia',
                'phylum' => 'Chordata',
                'class' => 'Amphibia',
                'order' => 'Anura',
                'family' => 'Dendrobatidae',
                'genu' => 'Dendrobates',
                'specie' => 'Dendrobates tinctorius',
            ],
        ]);
    }
}
