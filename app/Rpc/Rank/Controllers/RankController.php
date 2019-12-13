<?php

namespace App\Rpc\Rank\Controllers;

use Result;
use App\Models\User;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use App\Schedule\CheckMatch;
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
     * 接收用户请求，放入redis 匹配池
     * 检测匹配池用户数量，数量大于两个就组成匹配，
     * 同时前端定时器5秒内没有监听到匹配成功信号，
     * 自动请求机器人匹配接口。
     */
    public function doMatch(Request $request, User $user)
    {
        // user_id 存入 redis 链表
        Redis::lpush('rankList', $user->id);
        // client_id 存入redis hash表
        Redis::command('hset', ['rank', $user->id, $request->input('client_id')]);

        // 检测匹配池用户数量
        echo json_encode([
            'code' => 200,
            'data' => [
                'listLength' => Redis::llen('rankList'),
                'hash' => Redis::hgetall('rank'),
            ]
        ]);
    }

    /**
     * 监测匹配请求
     */
    public function CheckMatch()
    {
        if (RankService::CheckMatch()) {
            echo json_encode([
                'code' => 200
            ]);
        }
    }
}