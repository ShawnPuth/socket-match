<?php

namespace App\Rpc\Services;

use DB;
use App\Models\User;
use App\Models\Player;
use App\Models\PkRecord;
use App\Models\Question;

/**
 * 玩家服务
 *
 * @author Zhaoqiang Liu
 *
 * @version $Revision: 1.0 $
 */
class PlayerService
{   
    /**
     * 创建新玩家
     */
    public static function create($data)
    {   
        $player = new Player();
        
        $user = User::findOrFail($data['uid']);
        $player->user()->associate($user);
        $player->save();

        return $player;
    }

    /**
     * 获取当前玩家的详细信息
     */
    public static function getUserInfo(User $user)
    {
        $info = $user->info()->first();

        return $info;
    }
}   