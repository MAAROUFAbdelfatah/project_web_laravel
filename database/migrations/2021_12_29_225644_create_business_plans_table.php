<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('business_plans'))
        {    
            Schema::create('business_plans', function (Blueprint $table) {
                $table->id();
                $table->string("theme");
                $table->string("file_name")->nullable();
                $table->string("image")->nullable();
                $table->longText("description");
                $table->string("type_fin")->nullable();
                $table->string("valeur_fin")->nullable();
                $table->string("etat"); //enum("etat", ["valider", "no vlider", "au cours de traitement"]);
                $table->timestamps();
            });
        }
        Schema::table('business_plans', function (Blueprint $table) {
            $table->foreignId('equipe_id')->constrained('equipes');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_plans');
    }
}
