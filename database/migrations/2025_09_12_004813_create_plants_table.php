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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string("common_name");
            $table->enum("conservation_status", ['Least Concern','Near Threatened','Vulnerable','Endangered','Critically Endangered','Extinct in the Wild','Extinct']);
            $table->enum("type", ["Tree","Shrub","Herb","Vine","Grass","Fern","Moss","Algae","Succulent","Aquatic","Other"]);
            $table->enum("growth_form", ["Annual","Biennial","Perennial","Ephemeral","Evergreen","Deciduous","Semi-evergreen","Other"]);
            $table->enum("leaf_type", ["Simple","Compound","Pinnate","Bipinnate","Palmate","Trifoliate","Needle-like","Scale-like","Lobed","Other"]);
            $table->enum("leaf_arrangement", ["Alternate","Opposite","Whorled","Basal","Spiral","Distichous","Rosette","Other"]);
            $table->enum("fruit_type", ["Berry","Drupe","Pome","Hesperidium","Pepo","Capsule","Legume","Nut","Samara","Achene","Caryopsis","Aggregate","Multiple","Other"]);
            $table->enum("root_type", ["Taproot","Fibrous","Adventitious","Tuberous","Rhizome","Bulb","Corm","Aerial","Prop root","Pneumatophore","Other"]);
            $table->enum("soil", ["Sandy","Loamy","Clay","Silty","Peaty","Chalky","Saline","Rocky","Other"]);
            $table->enum("sunlight", ["Full Sun","Partial Shade","Shade","Other"]);
            $table->enum("water", ["Low","Medium","High","Other"]);
            $table->enum("reproduction", ['Sexual','Asexual','Sexual and Asexual']);
            $table->decimal("height", 4,1);
            $table->string("locale");
            $table->string("habitat");
            $table->enum("diet", ["Autotroph","Carnivorous","Parasitic","Saprophytic","Mycoheterotroph","Hemiparasite","Other"]);
            $table->decimal("life_span", 2,1);
            $table->decimal("growth_time", 2,1);
            $table->string("color");
            $table->enum("toxicity_level", ["Non-toxic", "Mildly toxic", "Moderately toxic", "Highly toxic", "Lethal"])->default("Non-toxic");
            $table->enum("treatment_necessity", ['None','Self-care','Recommended','Urgent','Critical'])->default("None");
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
        Schema::dropIfExists('plants');
    }
};
