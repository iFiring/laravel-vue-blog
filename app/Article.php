<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'cover', 'description', 'content_raw', 'content_html', 'is_draft', 'visitor', 'comment', 'sorts_id'
    ];

    /**
     * 获得此文章的分类
     */
    public function sorts()
    {
        return $this->belongsTo('App\Sort');
    }
}
