<?php

namespace App\Rpc\Services;

use DB;
use Carbon\Carbon;
use App\Models\Season;
use App\Models\Question;

/**
 * 排位赛服务
 *
 * @author Zhaoqiang Liu
 *
 * @version $Revision: 1.0 $
 */
class RankService
{   
    /**
     * 获取当前赛季信息
     */
    public static function getCurrentSeason()
    {
        $season = Season::where([
            ['start_at', '<=', Carbon::now()],
            ['end_at', '>=', Carbon::now()],
            ['status', 1],
        ])->first();

        return $season;
    }

    /**
     * 获取当前赛季段位列表
     */
    public static function getDanList(Season $season)
    {
        return $season->dans()->get();
    }
}   