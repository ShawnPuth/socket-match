<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 问题分类模型
 */
class QuestionType extends Model
{   
    protected $connection = 'mysql';

    protected $table = 'hc_question_type';

    /**
     * 不可以批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
}