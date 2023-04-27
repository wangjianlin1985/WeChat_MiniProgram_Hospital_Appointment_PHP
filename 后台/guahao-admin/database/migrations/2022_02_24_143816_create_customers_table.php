<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',80)->nullable()-> comment('用户名');
            $table->string('password')->default('')->comment('密码');
            $table->string('phone',20)->nullable()->comment('手机号');
            $table->string('avatar',256)->nullable()->comment('头像');
            $table->string('sex')->nullable()->comment('性别');
            $table->string('idcard')->nullable()->comment('身份证号');
            $table->string('address')->nullable()->comment('地址');
            $table->string('openid')->nullable()->comment('openid');
            $table->integer('status')->default(1)->comment('状态1正常0拉黑');
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
        Schema::dropIfExists('customers');
    }
}
