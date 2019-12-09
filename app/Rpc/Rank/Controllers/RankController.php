<?php

namespace App\Rpc\Rank\Controllers;

use Result;
use App\Models\User;
use Illuminate\Http\Request;
use App\Rpc\Services\RankService;
use App\Rpc\Services\PlayerService;
use App\Http\Controllers\Controller;

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
}