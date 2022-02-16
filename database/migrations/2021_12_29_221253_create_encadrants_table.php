<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncadrantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('encadrants')){
        
            Schema::create('encadrants', function (Blueprint $table) {
                $table->id();
                /*$table->string("nom");
                $table->string("prenom");
                $table->string("email")->unique();
                $table->string("telephone")->unique();
                $table->string("CIN")->unique();
                $table->string("password");
                $table->rememberToken();*/
                $table->string("type"); //["habilite", "noHabilite"]);
                $table->timestamps();
            });
        }

        Schema::table('encadrants', function (Blueprint $table) {
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
        Schema::dropIfExists('encadrements');
    }
}
