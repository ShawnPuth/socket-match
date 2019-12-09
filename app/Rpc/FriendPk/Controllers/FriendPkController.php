<?php

namespace App\Rpc\FriendPk\Controllers;

use Result;
use App\Models\Player;
use App\Models\PkRecord;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rpc\Services\QuestionService;
use App\Rpc\Services\PkRecordService;

/**
 * 好友对战管理
 * 
 * @author Zhaoqiang Liu
 * 
 * @version $Revision: 1.0 $
 */
class FriendPkController extends Controller
{  
    /**
     * 建立对战房间
     * 
     * @param   \Illuminate\Http\Request    $request
     * 
     * @return  \App\System\Facades\Result
     */
    public function create(Request $request, Player $sponsor)
    {
        // 抽取问题
        $questions = QuestionService::extractQuestion();
        // 创建好友对战记录
        $pkRecord = PkRecordService::createRoom($sponsor, $questions, $type = 1);

        // 返回房间ID
        return Result::success($pkRecord->id);
    }

    /**
     * 检查被邀请玩家是否加入房间,如果加入返回玩家信息
     */
    public function checkJoin(Request $request, PkRecord $pkRecord)
    {
        
    }

    /**
     * 好友已加入房间，修改房间状态
     */
    public function joined(Request $request, PkRecord $pkRecord)
    {   
        // 修改房间状态
        PkRecordService::updateRoom($pkRecord, $request->only([
            'uid', 'leave'
        ]));

        return Result::success();
    }
}