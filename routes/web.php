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
// 测试
Route::post('/test/{user}/index', 'Test@index');
Route::get('/test/match', 'Test@match');
Route::get('/test/clear', 'Test@clearRedis');


// 模拟RPC网关
// Route::group(['namespace' => '\App\Rpc'], function () {
//     Route::get('test', 'TestController@index')->name('test.index');
// });

// 登录  --  跳转--建立连接--绑定$_SESSION  --匹配
Route::view('login',  'auth.login')->middleware('guest');
Route::group(['prefix' => 'auth', 'namespace' => '\App\Rpc\Auth\Controllers'], function ($route) {
    Route::post('login', 'Login')->name('auth.login');
    Route::get('logout', 'Logout')->name('auth.logout');
});

// 聊天室demo
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::get('chat', 'ChatController@index')->name('chat.index');
});

Route::group(['middleware' => ['auth']], function () {
    // 匹配视图
    Route::view('/match',  'match.index');
    // 玩家
    Route::group(['prefix' => 'player', 'namespace' => '\App\Rpc\Player\Controllers'], function ($route) {
        // 查看是否是竞赛新玩家
        Route::get('checkNew', 'PlayerController@checkNew')->name('player.checkNew');
    });
    // 好友对战
    Route::group(['prefix' => 'friendPk', 'namespace' => '\App\Rpc\FriendPk\Controllers'], function ($route) {
        // 创建房间
        Route::post('/create/{sponsor}', 'FriendPkController@create')->name('friendPk.create');
        // 检查好友是否加入房间
        Route::get('/checkJoin/{pkRecord}', 'FriendPkController@checkJoin')->name('friendPk.checkJoin');
        // 好友已加入房间
        Route::put('/joined/{pkRecord}', 'FriendPkController@joined')->name('friendPk.joined');
    });
    // 排位赛
    Route::group(['prefix' => 'rank', 'namespace' => '\App\Rpc\Rank\Controllers'], function ($route) {
        // 获取首页数据
        Route::get('/index/{user}', 'RankController@index')->name('rank.index');
        // 参与排位赛
        Route::post('/match', 'RankController@doMatch')->name('rank.match');
        // 监测并执行玩家匹配
        Route::post('/checkMatch', 'RankController@checkMatch')->name('rank.checkMatch');
        // 绑定用户Id
        Route::post('/bindUid', 'RankController@bindUid')->name('rank.bindUid');
    });
    // 排行榜

    // 转盘

    // 银行
});