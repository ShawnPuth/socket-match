<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 对战记录模型
 */
class PkRecord extends Model
{   
    protected $connection = 'mysql';

    protected $table = 'hc_pk_record';

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