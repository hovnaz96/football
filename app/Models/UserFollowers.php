<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFollowers extends Model
{
    protected $fillable = [
        'user_id','follower_id'
    ];

    public function userFollowing()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }


    public function userFollowers()
    {
        return $this->belongsTo('App\Models\User','follower_id','id');
    }

}
