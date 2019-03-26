<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sort extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'article_num'
    ];

    /**
     * 获得此分类的文章
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
