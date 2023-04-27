<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id')->comment('城市ID');
            $table->string('name',64)->default('')->comment('名称');
            $table->string('image',64)->default('')->comment('图片');
            $table->string('images',1024)->default('')->comment('图片集');
            $table->string('address',128)->default('')->comment('地址');
            $table->string('tel',16)->default('')->comment('医院电话');
            $table->text('intro')->nullable()->comment('简介');
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
        Schema::dropIfExists('hospitals');
    }
}
