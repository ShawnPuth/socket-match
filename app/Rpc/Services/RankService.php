<?php

namespace App\Rpc\Services;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Season;
use App\Models\Question;
use GatewayClient\Gateway;
use Illuminate\Support\Facades\Redis;
use App\Rpc\Services\PkRecordService;
use App\Rpc\Services\QuestionService;

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

    /**
     * 检测匹配池并执行匹配
     */
    public static function CheckMatch()
    {
        // 查询匹配池中数量
        $num = Redis::llen('rankList');

        if ($num >= 2) {
            $firstId = Redis::rpop('rankList');
            $firstClientId = Redis::hget('rank', $firstId);
            $secondId = Redis::rpop('rankList');
            $secondClientId = Redis::hget('rank', $secondId);
            // 删除hash中被取出的元素
            Redis::hdel('rank', $firstId);
            Redis::hdel('rank', $secondId);
            // 查询两个用户信息
            $firstUser = User::find($firstId);
            $secondUser = User::find($secondId);
            // 抽取问题
            $questions = QuestionService::extractQuestion();
            // 创建排位对战记录,获取房间号
            $pkRecord = PkRecordService::createRoom($firstUser, $questions, $type = 2);
            // 绑定uid到client_id;
            // Gateway::bindUid($firstClientId, $firstId);
            // Gateway::bindUid($secondClientId, $secondId);
            // 创建房间
            $roomId = $pkRecord->id;
            Gateway::setSession($firstClientId, [
                'id' => $firstUser->id,
                'nickname' => $firstUser->nick_name,
                'avatar' => $firstUser->avatar
            ]);
            Gateway::bindUid($firstClientId, $firstId);
            Gateway::joinGroup($firstClientId, $roomId);
            // 用户2进入房间
            Gateway::setSession($secondClientId, [
                'id' => $secondUser->id,
                'nickname' => $secondUser->nick_name,
                'avatar' => $secondUser->avatar
            ]);
            Gateway::bindUid($secondClientId, $secondId);
            Gateway::joinGroup($secondClientId, $roomId);
            // 获取房间玩家信息
            $clients_list = Gateway::getClientSessionsByGroup($roomId);
            foreach ($clients_list as $tmp_client_id => $item) {
                $userList[]=$item;
            }
            $new_message = array(
                'type' => 'rank',
                'content' => $userList
            );

            // 房间用户信息发回前端
            Gateway::sendToGroup($roomId, json_encode($new_message));
        }

        return true;
    }

    /**
     * 匹配池检查并移除指定用户
     */
    public static function removeMatchUser($userId)
    {
        Redis::lrem('rankList', 0, $userId);
        Redis::hdel('rank', $userId);
    }
}   