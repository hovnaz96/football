<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    protected $fillable = ['message','from_id','to_id'];


    public function FromId()
    {
        return $this->belongsTo(User::class,'from_id','id');
    }


    public function userTo()
    {
        return $this->belongsTo(User::class,'to_id','id');
    }


    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M j, Y H:i a');
    }

    public function getUsersWhoHaveMessagesAttribute()
    {
        if(Auth::check())
        {
            $arr = Message::select(['to_id','from_id'])->where('to_id',Auth::user()->id)->orderBy('created_at','DESC')->get()->pluck('from_id')->toArray();
            $arr = array_merge($arr,Message::select(['to_id','from_id'])->where('from_id',Auth::user()->id)->orderBy('created_at','DESC')->get()->pluck('to_id')->toArray());
            $arr = array_unique($arr);
            $ids_ordered = implode(',', $arr);
            $users = User::select(['id','firstname','lastname','slug'])->whereIn('id',$arr)->with(['messagesTo'=>function($query){
                $query->select(['message','created_at'])->orderBy('created_at','ASC');
            },'messagesFrom'])->orderByRaw(\DB::raw("FIELD(id, $ids_ordered)"))->get();
            return $users;
        }
    }

    public function getUsersWhoHaveMessagesHeaderAttribute()
    {
        if(Auth::check())
        {
            $arr = Message::select(['to_id','from_id'])->where('to_id',Auth::user()->id)->orderBy('created_at','DESC')->get()->pluck('from_id')->toArray();
            $arr = array_merge($arr,Message::select(['to_id','from_id'])->where('from_id',Auth::user()->id)->orderBy('created_at','DESC')->get()->pluck('to_id')->toArray());
            $arr = array_unique($arr);
            $ids_ordered = implode(',', $arr);
            $users = User::select(['id','firstname','lastname','slug'])->whereIn('id',$arr)->with(['messagesTo'=>function($query){
                $query->select(['message','created_at'])->orderBy('is_seen','ASC');
            },'messagesFrom'])->orderByRaw(\DB::raw("FIELD(id, $ids_ordered)"))->limit(4)->get();

            return $users;
        }
    }

}
