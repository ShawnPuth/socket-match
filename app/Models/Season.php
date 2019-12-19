<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 赛季模型
 */
class Season extends Model
{   
    protected $connection = 'mysql';

    protected $table = 'season';

    /**
     * 不可以批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 与段位一对多的关系
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dans()
    {
        return $this->hasMany('App\Models\Dan', 'season');
    }
}