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
            $table->enum("conservation_status", ['Least Concern','Near Threatened','Vulnerable','Endangered','Critically Endangered','Extinct in the Wild','Extinct']);
            $table->decimal("weight", 4,1);
            $table->decimal("height", 4,1);
            $table->decimal("length", 3,2);
            $table->string("locale");
            $table->string("habitat");
            $table->enum("diet", ["Herbivore","Carnivore","Omnivore","Insectivore","Frugivore","Folivore","Nectarivore","Piscivore","Detritivore","Scavenger","Other"]);
            $table->enum("reproduction", ['Sexual','Asexual','Sexual and Asexual']);
            $table->decimal("life_span", 2,1);
            $table->string("color");
            $table->enum("danger_level", ['Harmless','Mild','Moderate','Dangerous','Extreme'])->default("Harmless");
            $table->enum("treatment_necessity", ['None','Self-care','Recommended','Urgent','Critical'])->default("None");
            $table->text("prevention")->nullable();
            $table->text("description")->nullable();
            $table->integer("inaturalist_id");
            $table->integer("gbif_id");
            $table->foreignId("specie_id")->constrained()->onDelete("cascade");
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
