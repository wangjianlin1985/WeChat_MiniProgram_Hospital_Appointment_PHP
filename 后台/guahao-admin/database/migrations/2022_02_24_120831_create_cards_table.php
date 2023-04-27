<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('openid')->nullable()->comment('openid');
            $table->string('name',32)->nullable()->comment('姓名');
            $table->string('idcard')->nullable()->comment('身份证号');
            $table->string('phone',11)->nullable()->comment('手机号');
            $table->string('sex')->nullable()->comment('性别');
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
        Schema::dropIfExists('cards');
    }
}
