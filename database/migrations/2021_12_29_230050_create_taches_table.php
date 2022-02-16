<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('taches'))
        {
            Schema::create('taches', function (Blueprint $table) {
                $table->id();
                //$table->foreignId('business-plan_id')->constrained('business-plans');
                //$table->foreignId('article_id')->constrained('articles');
                $table->string("nom");
                $table->longText("description");
                $table->integer('delai_estimer');
                $table->integer('delai_real')->nullable();
                $table->date('debut')->nullable();
                $table->date('fin')->nullable();
                $table->string("etat");//["valider", "au cours de traitemrent", "stop"]);
                $table->timestamps();
            });
        }

        Schema::table('taches', function (Blueprint $table) {
            $table->foreignId('businessPlan_id')->constrained('business_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taches');
    }
}
