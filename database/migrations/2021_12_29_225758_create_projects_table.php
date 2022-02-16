<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // if(!Schema::hasTable('projects'))
        // {    
        //     Schema::create('projects', function (Blueprint $table) {
        //         $table->id();
        //         $table->timestamps();
        //     });
        // }
        // Schema::table('projects', function (Blueprint $table) {
        //     $table->foreignId('equipe_id')->constrained('equipes');
        //     $table->foreignId('businessPlan_id')->constrained('business_plans');
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
