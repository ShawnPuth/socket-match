<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 用户模型
 */
class User extends Authenticatable
{   
    protected $connection = 'mysql';

    protected $table = 'user';

    /**
     * 不可以批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 与玩家详情的一对一关系
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function info()
    {
        return $this->hasOne('App\Models\UserInfo', 'uid');
    }
}