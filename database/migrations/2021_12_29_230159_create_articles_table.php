<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('articles'))
        {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string("file_name");
                $table->string("titre");
                $table->integer('nombre_pages');
                $table->longText("abstract");
                $table->string('type_pub');
                $table->timestamps();
            });
        }

        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('businessPlan_id')->constrained('business_plans');
            // $table->foreignId('journal_id')->nullable()->constrained('journals');
            // $table->foreignId('conference_id')->nullable()->constrained('conferences');
        });
           
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
