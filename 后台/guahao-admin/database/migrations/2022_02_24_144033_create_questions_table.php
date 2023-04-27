<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('questionnaire_id')->default(0)->comment('问卷ID');
            $table->integer('no')->default(0)->comment('序号');
            $table->string('question',256)->comment('题目');
            $table->string('optiona',256)->nullable()->comment('选项A');
            $table->integer('counta')->default(0)->comment('选型A人数');
            $table->string('optionb',256)->nullable()->comment('选项B');
            $table->integer('countb')->default(0)->comment('选型B人数');
            $table->string('optionc',256)->nullable()->comment('选项C');
            $table->integer('countc')->default(0)->comment('选型C人数');
            $table->string('optiond',256)->nullable()->comment('选项D');
            $table->integer('countd')->default(0)->comment('选型D人数');
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
        Schema::dropIfExists('questions');
    }
}
