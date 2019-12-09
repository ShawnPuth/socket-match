<?php

namespace App\Rpc\Services;

use DB;
use App\Models\Question;

/**
 * 题库服务
 *
 * @author Zhaoqiang Liu
 *
 * @version $Revision: 1.0 $
 */
class QuestionService
{   
    /**
     * 随机抽取对战问题
     */
    public static function extractQuestion()
    {
        return $randomQuestion = Question::inRandomOrder()
                                ->limit(5)
                                ->get();      
    }
}   