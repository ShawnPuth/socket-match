<?php

namespace App\Rpc\Player\Controllers;

use Result;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Rpc\Services\PlayerService;
use App\Http\Controllers\Controller;

/**
 * 玩家管理
 * 
 * @author Zhaoqiang Liu
 * 
 * @version $Revision: 1.0 $
 */
class PlayerController extends Controller
{   
    /**
     * 检查用户是否是竞赛模块新玩家,如果是返回玩家资料，如果不是创建账户并返回资料
     * 
     * @param   \Illuminate\Http\Request    $request
     * 
     * @return  \App\System\Facades\Result
     */
    public function checkNew(Request $request)
    {   
        $player = Player::where('uid',$request->uid)->first();
        if (!$player) {
            $player = PlayerService::create($request->only(['uid']));
        }

        return Result::success($player[0]);
    }
}