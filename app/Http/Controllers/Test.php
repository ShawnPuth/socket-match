<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
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
     * 处理请求。
     */
    public function __invoke()
    {   
        // $clientId1 = 11;
        // $user1 = User::find(1);

        // $redis->hset('rank', $user1->id, $clientId1);  //将key为'key1' value为'v1'的元素存入hash1表
        // $redis->hset('rank', $user2->id, $clientId2);
        Redis::command('hset', ['rank', 1, 11]);
        Redis::command('hset', ['rank', 2, 22]);
        Redis::command('hset', ['rank', 3, 33]);
        Redis::command('hset', ['rank', 4, 44]);

        $num = Redis::hlen('rank');
        if ($num>=2) {
            // 取出所有的key
            $hkeys = Redis::hkeys('rank');
            // 获取Hash中所有的元素
            $lists = Redis::hgetall('rank');
            // 取出hash中前两个key 和 value 赋值
            $firstId = $hkeys[0];
            $firstClientId = $lists[$firstId];
            $secondId = $hkeys[1];
            $secondClientId = $lists[$secondId];
            // 删除hash中被取出的元素
            Redis::hdel('rank', $firstId);
            Redis::hdel('rank', $secondId);
            // 查询两个用户信息并发送给woker返回前端 
        }

        dd(Redis::hgetall('rank'));
    }
}