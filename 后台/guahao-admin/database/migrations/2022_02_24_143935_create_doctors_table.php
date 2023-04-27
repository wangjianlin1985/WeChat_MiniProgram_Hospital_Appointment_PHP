<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id')->comment('城市ID');
            $table->unsignedBigInteger('hospital_id')->comment('医院ID');
            $table->unsignedBigInteger('department_id')->comment('科室ID');
            $table->string('name',80)->default('')->comment('姓名');
            $table->string('code',80)->default('')->comment('账号');
            $table->string('phone', 20)->nullable()->comment('手机号');
            $table->string('avatar', 256)->nullable()->comment('头像');
            $table->string('sex')->nullable()->comment('性别');
            $table->string('idcard')->nullable()->comment('身份证号');
            $table->string('address')->nullable()->comment('地址');
            $table->text('intro')->nullable()->comment('简介');
            $table->integer('counts')->default(0)->comment('预约人数');
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
        Schema::dropIfExists('doctors');
    }
}
