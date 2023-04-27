<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::prefix('admin')->namespace('Admin')->group(function () {

    //上传图片
    Route::post('/uploadImg', 'UploadController@uploadImg')->name('uploadImg');
    //上传文件
    Route::post('/uploadFile', 'UploadController@uploadFile')->name('uploadFile');

    //登录页
    Route::get('/login', 'IndexController@login')->name('admin.login');
    //登录方法
    Route::post('/login', 'IndexController@vlogin')->name('admin.login');
    //修改密码
    Route::get('/pass', 'IndexController@pass')->name('admin.pass');
    //修改密码方法
    Route::post('/vpass', 'IndexController@vpass')->name('admin.vpass');
    //退出登录
    Route::get('/logout', 'IndexController@logout')->name('admin.logout');
    //个人信息
    Route::get('/person', 'IndexController@person')->name('admin.person');

    //校验登录中间件检测是否登录
    Route::group(['middleware' => 'verifyLogin'], function () {

        //后台首页
        Route::get('/', 'IndexController@index')->name('admin.index');
        Route::get('/index', 'IndexController@index')->name('admin.index');

        //用户管理
        Route::prefix('user')->group(function () {
            Route::get('list', 'UserController@list')->name('admin.user.list');
            Route::get('getTable', 'UserController@getTable')->name('admin.user.getTable');
            Route::get('add', 'UserController@add')->name('admin.user.add');
            Route::post('save', 'UserController@save')->name('admin.user.save');
            Route::get('edit/{id}', 'UserController@edit')->name('admin.user.edit');
            Route::post('update', 'UserController@update')->name('admin.user.update');
            Route::get('delete', 'UserController@delete')->name('admin.user.delete');
        });

        //城市管理
        Route::prefix('city')->group(function () {
            Route::get('list', 'CityController@list')->name('admin.city.list');
            Route::get('getTable', 'CityController@getTable')->name('admin.city.getTable');
            Route::get('add', 'CityController@add')->name('admin.city.add');
            Route::post('save', 'CityController@save')->name('admin.city.save');
            Route::get('edit/{id}', 'CityController@edit')->name('admin.city.edit');
            Route::post('update', 'CityController@update')->name('admin.city.update');
            Route::get('delete', 'CityController@delete')->name('admin.city.delete');
        });

        //医院管理
        Route::prefix('hospital')->group(function () {
            Route::get('select', 'HospitalController@select')->name('admin.hospital.select');
            Route::get('list', 'HospitalController@list')->name('admin.hospital.list');
            Route::get('getTable', 'HospitalController@getTable')->name('admin.hospital.getTable');
            Route::get('add', 'HospitalController@add')->name('admin.hospital.add');
            Route::post('save', 'HospitalController@save')->name('admin.hospital.save');
            Route::get('edit/{id}', 'HospitalController@edit')->name('admin.hospital.edit');
            Route::post('update', 'HospitalController@update')->name('admin.hospital.update');
            Route::get('delete', 'HospitalController@delete')->name('admin.hospital.delete');
        });

        //科室管理
        Route::prefix('department')->group(function () {
            Route::get('select', 'DepartmentController@select')->name('admin.department.select');
            Route::get('list', 'DepartmentController@list')->name('admin.department.list');
            Route::get('getTable', 'DepartmentController@getTable')->name('admin.department.getTable');
            Route::get('add', 'DepartmentController@add')->name('admin.department.add');
            Route::post('save', 'DepartmentController@save')->name('admin.department.save');
            Route::get('edit/{id}', 'DepartmentController@edit')->name('admin.department.edit');
            Route::post('update', 'DepartmentController@update')->name('admin.department.update');
            Route::get('delete', 'DepartmentController@delete')->name('admin.department.delete');
        });

        //医生管理
        Route::prefix('doctor')->group(function () {
            Route::get('list', 'DoctorController@list')->name('admin.doctor.list');
            Route::get('getTable', 'DoctorController@getTable')->name('admin.doctor.getTable');
            Route::get('add', 'DoctorController@add')->name('admin.doctor.add');
            Route::post('save', 'DoctorController@save')->name('admin.doctor.save');
            Route::get('edit/{id}', 'DoctorController@edit')->name('admin.doctor.edit');
            Route::post('update', 'DoctorController@update')->name('admin.doctor.update');
            Route::get('delete', 'DoctorController@delete')->name('admin.doctor.delete');
            Route::get('plan', 'DoctorController@plan')->name('admin.plan.plan');
        });

        //医生出诊
        Route::prefix('plan')->group(function () {
            Route::get('list', 'PlanController@list')->name('admin.plan.list');
            Route::get('getTable', 'PlanController@getTable')->name('admin.plan.getTable');
            Route::post('save', 'PlanController@save')->name('admin.plan.save');
            Route::post('update', 'PlanController@update')->name('admin.plan.update');
            Route::get('delete', 'PlanController@delete')->name('admin.plan.delete');
        });

        //新闻公告
        Route::prefix('article')->group(function () {
            Route::get('list', 'ArticleController@list')->name('admin.article.list');
            Route::get('getTable', 'ArticleController@getTable')->name('admin.article.getTable');
            Route::get('add', 'ArticleController@add')->name('admin.article.add');
            Route::post('save', 'ArticleController@save')->name('admin.article.save');
            Route::get('edit/{id}', 'ArticleController@edit')->name('admin.article.edit');
            Route::post('update', 'ArticleController@update')->name('admin.article.update');
            Route::get('delete', 'ArticleController@delete')->name('admin.article.delete');
        });

        //视频管理
        Route::prefix('banner')->group(function () {
            Route::get('list', 'BannerController@list')->name('admin.banner.list');
            Route::get('getTable', 'BannerController@getTable')->name('admin.banner.getTable');
            Route::get('add', 'BannerController@add')->name('admin.banner.add');
            Route::post('save', 'BannerController@save')->name('admin.banner.save');
            Route::get('edit/{id}', 'BannerController@edit')->name('admin.banner.edit');
            Route::post('update', 'BannerController@update')->name('admin.banner.update');
            Route::get('delete', 'BannerController@delete')->name('admin.banner.delete');
        });

        //问卷调查
        Route::prefix('questionnaire')->group(function () {
            Route::get('list', 'QuestionnaireController@list')->name('admin.questionnaire.list');
            Route::get('getTable', 'QuestionnaireController@getTable')->name('admin.questionnaire.getTable');
            Route::get('add', 'QuestionnaireController@add')->name('admin.questionnaire.add');
            Route::post('save', 'QuestionnaireController@save')->name('admin.questionnaire.save');
            Route::get('edit/{id}', 'QuestionnaireController@edit')->name('admin.questionnaire.edit');
            Route::post('update', 'QuestionnaireController@update')->name('admin.questionnaire.update');
            Route::get('question/{id}', 'QuestionnaireController@question')->name('admin.questionnaire.question');
            Route::get('delete', 'QuestionnaireController@delete')->name('admin.questionnaire.delete');
        });

        //问卷调查-题目
        Route::prefix('question')->group(function () {
            Route::get('getTable', 'QuestionController@getTable')->name('admin.question.getTable');
            Route::post('save', 'QuestionController@save')->name('admin.question.save');
            Route::post('update', 'QuestionController@update')->name('admin.question.update');
            Route::get('delete', 'QuestionController@delete')->name('admin.question.delete');
        });

        //会员
        Route::prefix('customer')->group(function(){
            Route::get('list','CustomerController@list')->name('admin.customer.list');
            Route::any('update','CustomerController@update')->name('admin.customer.update');
            Route::any('delete','CustomerController@delete')->name('admin.customer.delete');
            Route::get('getTable','CustomerController@getTable')->name('admin.customer.getTable');
        });

        //订单
        Route::prefix('order')->group(function(){
            Route::get('day','OrderController@day')->name('admin.order.day');
            Route::get('list','OrderController@list')->name('admin.order.list');
            Route::get('getTable','OrderController@getTable')->name('admin.order.getTable');
            Route::get('update', 'OrderController@update')->name('admin.message.update');
            Route::get('delete', 'OrderController@delete')->name('admin.question.delete');
        });

        //留言
        Route::prefix('message')->group(function(){
            Route::get('list','MessageController@list')->name('admin.message.list');
            Route::get('getTable','MessageController@getTable')->name('admin.message.getTable');
            Route::post('save', 'MessageController@save')->name('admin.message.save');
            Route::post('update', 'MessageController@update')->name('admin.message.update');
            Route::get('delete', 'MessageController@delete')->name('admin.message.delete');
            Route::get('doctor','MessageController@doctor')->name('admin.message.doctor');
        });


    });

});


