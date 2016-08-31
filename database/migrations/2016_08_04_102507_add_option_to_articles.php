<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOptionToArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function ($table) {
            $table->integer('creative')->default('0');
            $table->integer('profit')->default('0');
            $table->integer('share')->default('0');
            $table->integer('open')->default('1');
            $table->text('tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function ($table) {
            $table->dropColumn(['creative','profit','share','open','tag']);
        });
    }
}
