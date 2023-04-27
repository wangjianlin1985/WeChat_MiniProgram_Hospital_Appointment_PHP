<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('openid')->nullable()->comment('openid');
            $table->unsignedBigInteger('hospital_id')->comment('医院ID');
            $table->unsignedBigInteger('department_id')->comment('科室ID');
            $table->unsignedBigInteger('doctor_id')->comment('医生ID');
            $table->unsignedBigInteger('plan_id')->comment('医生出诊ID');
            $table->string('order_no')->nullable()->comment('订单号');
            $table->string('card')->nullable()->comment('就诊人');
            $table->string('message')->nullable()->comment('订单留言');
            $table->decimal('totals',8,2)->default(0)->comment('合计');
            $table->integer('status')->default(0)->comment('状态');
            $table->integer('is_pay')->default(0)->comment('是否支付');
            $table->string('sn')->nullable()->comment('挂号');
            $table->string('pay_type')->nullable()->comment('支付方式');
            $table->string('pay_time')->nullable()->comment('支付时间');
            $table->string('pay_money')->nullable()->comment('支付金额');
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
        Schema::dropIfExists('orders');
    }
}
