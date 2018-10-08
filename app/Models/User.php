<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    use Sluggable;

    protected $_birthplace;
    protected $_social_links;
    protected $_messages_users;
    protected $_image_likes;
    protected $_video_likes;
    protected $_followed;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname','lastname','username', 'email', 'password','year','day','month'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','isAdmin'
    ];

    protected $appends = [
        'user_profile_image_medium','user_profile_image_large','user_profile_image_small','full_name','last_message','user_profile_url'
    ];

    protected  $social_links = ['facebook','twitter','google_plus','instagram','user_id'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => ['firstname','lastname']
            ]
        ];
    }

    public function isAdmin()
    {
        return $this->isAdmin;
    }


    public function getFullNameAttribute()
    {
        return $this->attributes['firstname'].' '. $this->attributes['lastname'];
    }

    public function getUserProfileImageSmallAttribute()
    {
        if(file_exists(public_path('uploads/users_profile/'.$this->attributes['id'].'_small.png'))){
            return asset('uploads/users_profile/'.$this->attributes['id'].'_small.png');
        }else{
            return asset('default_images/profile.png');
        }
    }


    public function getUserProfileImageMediumAttribute()
    {
        if(file_exists(public_path('uploads/users_profile/'.$this->attributes['id'].'_medium.png'))){
            return asset('uploads/users_profile/'.$this->attributes['id'].'_medium.png');
        }else{
            return asset('default_images/profile.png');
        }
    }


    public function getUserProfileImageLargeAttribute()
    {
        if(file_exists(public_path('uploads/users_profile/'.$this->attributes['id'].'_large.png'))){
            return asset('uploads/users_profile/'.$this->attributes['id'].'_large.png');
        }else{
            return asset('default_images/profile.png');
        }
    }

    public function personal_info()
    {
        return $this->hasOne('App\Models\PersonalInformation','user_id','id');
    }


    public function getBirthplaceAttribute()
    {
        if(!$this->_birthplace)
        {
            $this->_birthplace = PersonalInformation::select(['city','country_id','user_id'])->with(['country'=>function($query){
                $query->select('id','citizenship');
            }])->where('user_id',$this->attributes['id'])->first();
        }


        if(is_null($this->_birthplace->country) && is_null($this->_birthplace->city)){
            return null;
        }

        return $this->_birthplace->country->citizenship. ' ' . $this->_birthplace->city;
    }

    public function getSocialLinksAttribute()
    {
        if(!$this->_social_links)
        {
            $this->_social_links = PersonalInformation::select($this->social_links)->where('user_id',$this->attributes['id'])->first();
        }


        if(is_null($this->_social_links->facebook) && is_null($this->_social_links->twitter) && is_null($this->_social_links->google_plus) && is_null($this->_social_links->instagram))
        {
            return null;
        }

        return $this->_social_links;
    }


    public function followingRelation()
    {
        return $this->hasMany('App\Models\UserFollowers','user_id','id');
    }

    public function followersRelation()
    {
        return $this->hasMany('App\Models\UserFollowers','follower_id','id');
    }


    public function getFollowingAttribute()
    {

        $data = $this->with(['followingRelation'=>function($query){
            $query->with('userFollowers');
        }])->where('id',$this->attributes['id'])->get();

        return $data;
    }

    public function getFollowersAttribute()
    {

        $data = $this->with(['followersRelation'=>function($query){
            $query->with('userFollowing');
        }])->where('id',$this->attributes['id'])->get();

        return $data;
    }


    public function getIsFollowingAttribute()
    {
        if(Auth::check()){
            $count = UserFollowers::where('user_id',Auth::user()->id)->where('follower_id',$this->attributes['id'])->count();
            if($count){
                return true;
            }

            return false;
        }

        return null;
    }

    public function checkIsFollowed($id)
    {
        if(!$this->_followed){
            if(Auth::check()){
                $this->_followed = UserFollowers::select(['follower_id'])->where('user_id',Auth::user()->id)->get()->toArray();
                if(in_array($id,array_column($this->_followed,'follower_id'))){
                    return true;
                }

                return false;
            }

            return false;

        }else{
            if(Auth::check()) {
                if (in_array($id, array_column($this->_followed, 'follower_id'))) {
                    return true;
                }

                return false;
            }
            return false;
        }

    }


    public function messagesTo()
    {
        return $this->hasMany(Message::class,'to_id','id');
    }

    public function messagesFrom()
    {
        return $this->hasMany(Message::class,'from_id','id');
    }

    public function getLastMessageAttribute()
    {

        if(!$this->_messages_users)
        {
            $this->_messages_users = Message::where('from_id',$this->attributes['id'])->where('to_id',Auth::user()->id)->orWhere('to_id',$this->attributes['id'])->where('from_id',Auth::user()->id)->orderBy('created_at','DESC')->first();
        }

        return $this->_messages_users;
    }


    public function messages()
    {
        if(Auth::check())
        {
            $data1 = Message::select(['from_id','messages'])->where('to_id',Auth::user()->id)->get();
            $data2 = Message::select(['from_id','messages'])->where('from_id',Auth::user()->id)->get();
            $data = $data1->merge($data2);
            return $data->all();
        }
    }

    public function isLiked($image_id)
    {

        if(!$this->_image_likes)
        {
            if(Auth::check()){
                $this->_image_likes = ImageLike::select(['image_id'])->where('user_id',Auth::user()->id)->get()->toArray();

                if(in_array($image_id,array_column($this->_image_likes,'image_id'))){
                    return true;
                }

                return false;
            }

            return false;
        }else{
            if(Auth::check()) {
                if (in_array($image_id, array_column($this->_image_likes, 'image_id'))) {
                    return true;
                }

                return false;
            }
            return false;
        }

    }

    public function isLikedVideo($video_id)
    {

        if(!$this->_video_likes)
        {
            if(Auth::check()){
                $this->_video_likes = VideoLike::select(['video_id'])->where('user_id',Auth::user()->id)->get()->toArray();

                if(in_array($video_id,array_column($this->_video_likes,'video_id'))){
                    return true;
                }

                return false;
            }

            return false;
        }else{
            if(Auth::check()) {
                if (in_array($video_id, array_column($this->_video_likes, 'video_id'))) {
                    return true;
                }

                return false;
            }
            return false;
        }

    }


    public  function likes()
    {
        return $this->hasMany('App\Models\ImageLike','user_id','id');
    }


    public function getNotSeenMessagesAttributes()
    {
        return Message::where('to_id',Auth::user()->id)->where('is_seen',false)->get();
    }


    public function getUserAllImagesAttribute()
    {
        return UsersImage::where('user_id',$this->attributes['id'])->with(['user'])->withCount(['imageLike'])->orderBy('created_at','DESC')->get();
    }

    public function getUserAllVideosAttribute()
    {
        return Video::where('user_id',$this->attributes['id'])->with(['user'])->withCount(['videoLikes'])->orderBy('created_at','DESC')->get();
    }

    public function getUserProfileUrlAttribute()
    {
        return route('user.profile',['slug'=>$this->attributes['slug']]);
    }


    public function getUserProjectCountAttribute()
    {
        $images = UsersImage::where('user_id',$this->attributes['id'])->count();
        $videos = Video::where('user_id',$this->attributes['id'])->count();
        $materials = $images + $videos;
        return $materials;
    }

}
