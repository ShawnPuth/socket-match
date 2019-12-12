<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\PkRecord;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use App\Rpc\Services\PkRecordService;
use App\Rpc\Services\QuestionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

/**
 * 测试
 *
 * @author Zhaoqiang Liu
 *
 * @version $Revision: 1.0 $
 */
class Test extends Controller
{
    /**
     * 接受匹配请求，放入匹配池
     */
    public function index(Request $request, User $user)
    {   
        // user_id 存入 redis 链表
        Redis::lpush('rankList', $user->id);
        // client_id 存入redis hash表
        Redis::command('hset', ['rank', $user->id, $request->input('client_id')]);

        echo json_encode([
            'msg' => '正在匹配',
            'data' => [
                'listLength' => Redis::llen('rankList'),
                'hash' => Redis::hgetall('rank')
            ]
        ]);
    }

    // 手动匹配
    public function Match()
    {   
        // 查询匹配池中数量
        $num = Redis::llen('rankList');
    
        if ($num >= 2) {
            // dd($num);
            $firstId = Redis::lpop('rankList');
            $firstClientId = Redis::hget('rank', $firstId);
            $secondId = Redis::lpop('rankList');
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
            Gateway::bindUid($firstClientId, $firstId);
            Gateway::bindUid($secondClientId, $secondId);
            // 创建房间
            $roomId = $pkRecord->id;
            Gateway::setSession($firstClientId, [
                'id' => $firstUser->id,
                'nickname' => $firstUser->nick_name,
                'avatar' => $firstUser->avatar
            ]);
            Gateway::joinGroup($firstClientId, $roomId);
            // 用户2进入房间
            Gateway::setSession($secondClientId, [
                'id' => $secondUser->id,
                'nickname' => $secondUser->nick_name,
                'avatar' => $secondUser->avatar
            ]);
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
            return Gateway::sendToGroup($roomId, json_encode($new_message));
        }
    }

    // 清空redis
    public function clearRedis()
    {   
        // 清除rankList中 所有与 1 相等的值
        // Redis::lrem('rankList', 0, 1);
        // 删除 rank 中 key 为 1 的元素
        // Redis::hdel('rank', 1);
        
        dd(Redis::lrange('rankList', 0, 10));
        // dd(Redis::hgetall('rank'));
    }
}