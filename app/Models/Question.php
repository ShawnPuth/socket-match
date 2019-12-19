<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 问题模型
 */
class Question extends Model
{   
    protected $connection = 'mysql';

    protected $table = 'question';

    /**
     * 不可以批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
}