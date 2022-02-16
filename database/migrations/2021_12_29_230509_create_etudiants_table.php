<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('etudiants'))
        {
            Schema::create('etudiants', function (Blueprint $table) {
                $table->id();
                //$table->string("nom");
                //$table->string("prenom");
                //$table->string("email")->unique();
                //$table->string("CIN")->unique();
                $table->string("CNE")->unique();
                $table->string("appoger")->unique();
                //$table->string("password");
                $table->timestamps();
            });
        }

        Schema::table('etudiants', function (Blueprint $table) {
            $table->foreignId('equipe_id')->nullable()->constrained('equipes');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
}
