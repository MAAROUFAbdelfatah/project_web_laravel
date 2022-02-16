<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncadrantEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('encadrant_equipes'))
        {
            Schema::create('encadrant_equipes', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
            });
        }

        Schema::table('encadrant_equipes', function (Blueprint $table) {
            $table->foreignId('equipe_id')->constrained('equipes');
            $table->foreignId('encadrant_id')->constrained('encadrants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encadrant_equipes');
    }
}
