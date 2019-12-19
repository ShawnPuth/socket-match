<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 玩家游戏详情模型
 */
class UserInfo extends Model
{   
    protected $connection = 'mysql';

    protected $table = 'player_info';

    /**
     * 不可以批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 从属于用户模型的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'uid');
    }
}