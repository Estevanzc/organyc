<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animal_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string("common_name");
            $table->enum("conservation_status", ["N/A", "Extinct", "Extinct in the Wild", "Critically Endangered", "Endangered", "Vulnerable", "Near Threatened", "Least Concern", "Data Deficient", "Not Evaluated"])->default("N/A");
            $table->string("weight");
            $table->string("height");
            $table->string("length");
            $table->string("locale");
            $table->string("habitat")->nullable();
            $table->enum("diet", ["Herbivore","Carnivore","Omnivore","Insectivore","Frugivore","Folivore","Nectarivore","Piscivore","Detritivore","Scavenger","Other"])->default("Other");
            $table->enum("reproduction", ['Sexual','Asexual','Sexual and Asexual'])->default('Sexual');
            $table->string("life_span");
            $table->string("color");
            $table->enum("danger_level", ['Harmless','Mild','Moderate','Dangerous','Extreme'])->default("Harmless");
            $table->enum("treatment_necessity", ['None','Self-care','Recommended','Urgent','Critical'])->default("None");
            $table->text("prevention")->nullable();
            $table->text("description")->nullable();
            $table->integer("inaturalist_id");
            $table->integer("gbif_id");
            $table->string("photo");
            $table->string("kingdom");
            $table->string("phylum");
            $table->string("class");
            $table->string("order");
            $table->string("family");
            $table->string("genu");
            $table->string("specie");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_suggestions');
    }
};
