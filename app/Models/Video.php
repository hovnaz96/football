<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = ['views','user_id','extension'];

    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function getUrlVideoThumbnailAttribute()
    {
        if(file_exists(public_path('/uploads/videos/thumbnails/'.$this->attributes['id'].'_thumbnail.jpg'))){
            return asset('/uploads/videos/thumbnails/'.$this->attributes['id'].'_thumbnail.jpg');
        }else{
            return asset('/default_images/Video-Icon-crop.png');
        }

    }

    public function getDeleteThumbnailNameAttribute()
    {
        return public_path('/uploads/videos/thumbnails/'.$this->attributes['id'].'_thumbnail.jpg');
    }

    public function getDeleteVideoUrlAttribute()
    {
        return public_path('/uploads/videos/'.$this->user->id.'/'.$this->attributes['id'].'_video.'.$this->attributes['extension']);
    }

    public function getVideoUrlAttribute()
    {
        return asset('/uploads/videos/'.$this->user->id.'/'.$this->attributes['id'].'_video.'.$this->attributes['extension']);
    }

    public function VideoLikes()
    {
        return $this->hasMany('App\Models\VideoLike','video_id','id');
    }

}
