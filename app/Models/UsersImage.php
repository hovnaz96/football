<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersImage extends Model
{
    protected $fillable = ['views','likes','user_id'];


    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }


    public function getUrlImageSmallAttribute()
    {
        if(file_exists(public_path('/uploads/users/'.$this->user->id.'/'.$this->attributes['id'].'_small.png'))){
            return asset('/uploads/users/'.$this->user->id.'/'.$this->attributes['id'].'_small.png');
        }else{
            return asset('/default_images/Video-Icon-crop.png');
        }
    }

    public function getDeleteImageSmallAttribute()
    {
        return public_path('/uploads/users/'.$this->user->id.'/'.$this->attributes['id'].'_small.png');
    }

    public function getDeleteImageOriginalAttribute()
    {
        return public_path('/uploads/users/'.$this->user->id.'/'.$this->attributes['id'].'_original.png');
    }

    public function getUrlImageOriginalAttribute()
    {
        if(file_exists(public_path('/uploads/users/'.$this->user->id.'/'.$this->attributes['id'].'_original.png'))){
            return asset('/uploads/users/'.$this->user->id.'/'.$this->attributes['id'].'_original.png');
        }else{
            return asset('/default_images/Video-Icon-crop.png');
        }
    }

    public function imageLike()
    {
        return $this->hasMany('App\Models\ImageLike','image_id','id');
    }
}
