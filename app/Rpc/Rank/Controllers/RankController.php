<?php

namespace App\Rpc\Rank\Controllers;

use Result;
use App\Models\User;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use App\Rpc\Services\RankService;
use App\Rpc\Services\PlayerService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

/**
 * 排位赛管理
 * 
 * @author Zhaoqiang Liu
 * 
 * @version $Revision: 1.0 $
 */
class RankController extends Controller
{   
    // Gateway注册地址
    public function __construct()
    {
        Gateway::$registerAddress = '127.0.0.1:1236';
    }

    /**
     * 排位赛首页数据
     */
    public function index(Request $request, User $user)
    {   
        // 获取当前赛季信息
        $season = RankService::getCurrentSeason();
        // 获取当前赛季段位列表
        $danList = RankService::getDanList($season);
        // 获取当前用户信息
        $userInfo = PlayerService::getUserInfo($user);

        return Result::success([
            'season' => $season,
            'danList' => $danList,
            'userInfo' => $userInfo
        ]);
    }

    /**
     * 进入排位匹配池
     */
    public function doMatch(Request $request, User $user)
    {
        // 服务器做任务调度每秒监听redis的匹配用户，数量大于两个就组成匹配，
        // 向对手发送昵称，清除匹配数组，
        // 同时前端定时器5秒内没有监听到匹配成功信号，
        // 自动请求机器人匹配接口。

        // 接收用户放入redis匹配数组
        Redis::command('rank', [$user->id, $user->nickname, $user->avatar]);
    }
}