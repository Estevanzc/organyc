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
        Schema::create('plant_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string("common_name");
            $table->enum("conservation_status", ["N/A", "Extinct", "Extinct in the Wild", "Critically Endangered", "Endangered", "Vulnerable", "Near Threatened", "Least Concern", "Data Deficient", "Not Evaluated"])->default("N/A");
            $table->enum("type", ["Tree","Shrub","Herb","Vine","Grass","Fern","Moss","Algae","Succulent","Aquatic","Other"])->default("Other");
            $table->enum("growth_form", ["Annual","Biennial","Perennial","Ephemeral","Evergreen","Deciduous","Semi-evergreen","Other"])->default("Other");
            $table->enum("leaf_type", ["None","Simple","Compound","Pinnate","Bipinnate","Palmate","Trifoliate","Needle-like","Scale-like","Lobed","Other"])->default("None");
            $table->enum("leaf_arrangement", ["None","Alternate","Opposite","Whorled","Basal","Spiral","Distichous","Rosette","Other"])->default("None");
            $table->enum("fruit_type", ["None","Berry","Drupe","Pome","Hesperidium","Pepo","Capsule","Legume","Nut","Samara","Achene","Caryopsis","Aggregate","Multiple","Other"])->default("None");
            $table->enum("root_type", ["Taproot","Fibrous","Adventitious","Tuberous","Rhizome","Bulb","Corm","Aerial","Prop root","Pneumatophore","Other"])->default("Other");
            $table->enum("soil", ["Sandy","Loamy","Clay","Silty","Peaty","Chalky","Saline","Rocky","Other"])->default("Other");
            $table->enum("sunlight", ["None","Full Sun","Partial Shade","Shade","Other"])->default("None");
            $table->enum("water", ["Low","Medium","High","Other"])->default("Other");
            $table->enum("reproduction", ['Sexual','Asexual','Sexual and Asexual'])->default("Sexual");
            $table->decimal("height", 4,1);
            $table->string("locale");
            $table->string("habitat");
            $table->enum("diet", ["Autotroph","Carnivorous","Parasitic","Saprophytic","Mycoheterotroph","Hemiparasite","Other"])->default("Other");
            $table->decimal("life_span", 2,1);
            $table->decimal("growth_time", 2,1);
            $table->string("color")->nullable();
            $table->enum("toxicity_level", ["Non-toxic", "Mildly toxic", "Moderately toxic", "Highly toxic", "Lethal"])->default("Non-toxic");
            $table->enum("treatment_necessity", ['None','Self-care','Recommended','Urgent','Critical'])->default("None")->default("None");
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
        Schema::dropIfExists('plant_suggestions');
    }
};
