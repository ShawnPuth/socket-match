<?php

namespace App\Rpc\Services;

use DB;
use App\Models\User;
use App\Models\Player;
use App\Models\PkRecord;
use App\Models\Question;


/**
 * 好友对战服务
 *
 * @author Zhaoqiang Liu
 *
 * @version $Revision: 1.0 $
 */
class PkRecordService
{   
    /**
     * 创建对战房间，初始化对战记录
     */
    public static function createRoom(User $sponsor, $question, $type)
    {   
        $qid = '';
        // 格式化问题ID
        foreach ($question as $key => $val) {
			if ($key + 1 < count($question)) {
				$qid .= $val["id"] . ",";
			} else {
				$qid .= $val["id"];
			}
		}

        // 保存记录
        $pkRecord = new PkRecord([
            'userid_one' => $sponsor->id,
            'questions' => $qid,
            'type' => $type,//好友对战
        ]);
        $pkRecord->save();

        return $pkRecord;
    }

    /**
     * 修改房间状态
     */
    public static function updateRoom(PkRecord $pkRecord, $data)
    {
        $user = User::findOrFail($data['uid']);
        $pkRecord->user()->associate($user);
        $pkRecord->leave = $data['leave'];

        return $pkRecord->save();
    }
}   