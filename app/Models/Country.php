<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{


    public function personal_info()
    {
        return $this->belongsTo('App\Models\PersonalInformation','country_id','id');
    }
}
