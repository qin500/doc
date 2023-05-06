<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['as'=>'Home::'],function (){
    Route::get('/',[\App\Http\Controllers\Home\IndexController::class,"index"])->name('index');
    Route::get('/abc',function (){

        $file="111.txt";
        $handle=fopen($file,'a');
        fwrite($handle,date('Y-m-d H:i:s') . "\r\n");
        fclose($handle);
        echo time();
    });
    Route::get('/list',[\App\Http\Controllers\Home\IndexController::class,"list"])->name('list');
    Route::get('/article/{article}' ,[\App\Http\Controllers\Home\IndexController::class,"article"])->name('article');
    Route::get('/tagname',[\App\Http\Controllers\Home\IndexController::class,"tagname"])->name('tagname');
    Route::get('/category/{category}',[\App\Http\Controllers\Home\IndexController::class,"category"])->name('category');//返回某个分类下的文章
    Route::get('/search',[\App\Http\Controllers\Home\IndexController::class,"search"])->name('search');//搜索
    Route::get('/about',[\App\Http\Controllers\Home\IndexController::class,"about"])->name('about');//搜索
    Route::get('/sitemap.xml',[\App\Http\Controllers\Home\IndexController::class,"sitemap"])->name('sitemap');//搜索
    Route::get('/liuyan',[\App\Http\Controllers\Home\IndexController::class,"liuyan"])->name('liuyan');//搜索
});

Route::group(['as'=>'Admin::','prefix'=>"admin",'middleware'=>'ck'],function (){
    Route::get('/',[\App\Http\Controllers\Admin\IndexController::class,"index"])->name('index');
    Route::get("/article/tuisong",[\App\Http\Controllers\Admin\ArticleController::class,'tuisong'])->name("article.tuisong");//百度推送
    Route::resource('article',\App\Http\Controllers\Admin\ArticleController::class);
    Route::resource('category',\App\Http\Controllers\Admin\CategoryController::class);

    Route::match(['get','post'],'/admin/login',[\App\Http\Controllers\Admin\LoginController::class,'login'])->name('login');
    Route::match(['get','post'],'/info/myinfo',[\App\Http\Controllers\Admin\InfoController::class,'myinfo'])->name('info.myinfo');
    Route::match(['get','post'],'/info/setting',[\App\Http\Controllers\Admin\InfoController::class,'setting'])->name('info.setting');
    Route::match(['get','post'],'/info/passwordManage',[\App\Http\Controllers\Admin\InfoController::class,'passwordManage'])->name('info.passwordManage');
});

//文件上传操作
//Route::post('/admin/upload',[\App\Http\Controllers\Admin\InfoController::class,'upload'])->name('Upload::upload');
Route::post('/admin/uploadToken',[\App\Http\Controllers\Admin\InfoController::class,'uploadToken'])->name('Upload::uploadToken');



Route::match(['get','post'],'/admin/login',[\App\Http\Controllers\Admin\LoginController::class,'login'])->name('Admin::login');
Route::get('/admin/quit',[\App\Http\Controllers\Admin\LoginController::class,'quit'])->name('Admin::quit');

//用于前端检测是否登录
Route::post('/admin/qin500_authorized',[\App\Http\Controllers\Admin\LoginController::class,'qin500_authorized'])->name('Admin::qin500_authorized');
