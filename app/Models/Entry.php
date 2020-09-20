<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'datetime', 'title', 'body', 'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'datetime' => 'datetime',
    ];

    /**
     * 記事に関連するカテゴリを取得
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    /**
     * 記事に関連するユーザを取得
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
