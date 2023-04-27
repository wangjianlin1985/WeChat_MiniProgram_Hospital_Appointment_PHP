<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function () {

    //查询最新视频
    Route::get('/getBanner','ApiController@getBanner')->name('api.getBanner');
    //查询医生top10
    Route::get('/getDoctorTop10','ApiController@getDoctorTop10')->name('api.getDoctorTop10');
    //查询城市医院
    Route::get('/getCityHospital','ApiController@getCityHospital')->name('api.getCityHospital');
    //查询医院
    Route::get('/hospital/{id}','ApiController@hospital')->name('api.hospital');
    //查询科室医生
    Route::get('/getDepartmentDoctor','ApiController@getDepartmentDoctor')->name('api.getDepartmentDoctor');
    //查询文章
    Route::get('/getArticles','ApiController@getArticles')->name('api.getArticles');
    //查询文章信息
    Route::get('/article/{id}','ApiController@article')->name('api.article');
    //查询医生
    Route::get('/getDoctors','ApiController@getDoctors')->name('api.getDoctors');
    //查询医生明细
    Route::get('/doctor/{id}','ApiController@doctor')->name('api.doctor');
    //查询医生出诊
    Route::get('/plan/{id}/{date}','ApiController@plan')->name('api.plan');
    //查询帖子
    Route::get('/getForums','ApiController@getForums')->name('api.getForums');
    //查询帖子信息
    Route::get('/forum/{id}','ApiController@forum')->name('api.forum');
    //发布帖子
    Route::get('/saveForum','ApiController@saveForum')->name('api.saveForum');
    //回复帖子
    Route::get('/replyForum','ApiController@replyForum')->name('api.replyForum');
    //注册
    Route::get('/vreg', 'ApiController@vreg')->name('api.vreg');
    //登录
    Route::get('/vlogin', 'ApiController@vlogin')->name('api.vlogin');
    //查询个人信息
    Route::get('/getInfo/{openid}', 'ApiController@getInfo')->name('api.getInfo');
    //修改个人信息
    Route::get('/updateInfo/{openid}', 'ApiController@updateInfo')->name('api.updateInfo');
    //提交留言信息
    Route::get('/message/{id}/save','ApiController@messageSave')->name('api.messageSave');
    //提交预约
    Route::get('/saveOrder','ApiController@saveOrder')->name('api.saveOrder');
    //查询订单信息
    Route::get('/getOrder/{order_no}','ApiController@getOrder')->name('api.getOrder');
    //支付订单
    Route::get('/payOrder/{order_no}','ApiController@payOrder')->name('api.payOrder');
    //退款订单
    Route::get('/tkOrder/{order_no}','ApiController@tkOrder')->name('api.tkOrder');
    //取消订单
    Route::get('/cancelOrder/{order_no}','ApiController@cancelOrder')->name('api.cancelOrder');
    //查询个人订单
    Route::get('/findOrders/{openid}','ApiController@findOrders')->name('api.findOrders');
    //查询我的留言
    Route::get('/findMessage/{openid}','ApiController@findMessage')->name('api.findMessage');
    //查询我的帖子
    Route::get('/findForum/{openid}','ApiController@findForum')->name('api.findForum');
    //删除我的帖子
    Route::get('/delForum/{id}','ApiController@delForum')->name('api.delForum');
    //保存就诊卡
    Route::get('/card/save','ApiController@cardSave')->name('api.cardSave');
    //就诊卡明细
    Route::get('/card/get','ApiController@cardGet')->name('api.cardGet');
    //修改就诊卡
    Route::get('/card/update','ApiController@cardUpdate')->name('api.cardUpdate');
    //删除就诊卡
    Route::get('/card/del','ApiController@cardDel')->name('api.cardDel');
    //查询就诊卡
    Route::get('/card/find','ApiController@cardFind')->name('api.cardFind');
    //统计
    Route::get('/tongji','ApiController@tongji')->name('api.tongji');
});
