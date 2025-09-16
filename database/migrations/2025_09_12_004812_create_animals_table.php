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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string("common_name");
            $table->enum("conservation_status", ['Least Concern','Near Threatened','Vulnerable','Endangered','Critically Endangered','Extinct in the Wild','Extinct']);
            $table->string("weight");
            $table->string("height");
            $table->string("length");
            $table->string("locale");
            $table->string("habitat");
            $table->enum("diet", ["Herbivore","Carnivore","Omnivore","Insectivore","Frugivore","Folivore","Nectarivore","Piscivore","Detritivore","Scavenger","Other"]);
            $table->enum("reproduction", ['Sexual','Asexual','Sexual and Asexual']);
            $table->string("life_span");
            $table->string("color");
            $table->enum("danger_level", ['Harmless','Mild','Moderate','Dangerous','Extreme'])->default("Harmless");
            $table->enum("treatment_necessity", ['None','Self-care','Recommended','Urgent','Critical'])->default("None");
            $table->text("prevention")->nullable();
            $table->text("description")->nullable();
            $table->integer("inaturalist_id");
            $table->integer("gbif_id");
            $table->integer("eol_id");
            $table->foreignId("specie_id")->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
