<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    protected $fillable = ['user_id','occupation','country_id','city','facebook','twitter','google_plus','pinterest','instagram','description'];

    public function user()
    {
        return $this->belongsTo('App\Models\User','id','user_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Country','id','country_id');
    }
}
