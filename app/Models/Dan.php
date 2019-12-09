<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 排位赛段位模型
 */
class Dan extends Model
{   
    protected $connection = 'mysql';

    protected $table = 'hc_dan';

    /**
     * 不可以批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 从属于赛季的关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season()
    {
        return $this->belongsTo('App\Models\Season', 'season');
    }
}