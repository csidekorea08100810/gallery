<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('mention_name');
            $table->text('mention_id');
            $table->integer('article_id');
            $table->integer('comment_id');
            $table->integer('follower_id');
            $table->string('image');
            $table->string('type');
            $table->integer('user_id');
            $table->string('url');
            $table->boolean('checked')->default(false);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('alarms');
    }
}
