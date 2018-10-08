<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSiteSettings extends Model
{
    protected  $fillable = ['facebook','twitter','google_plus','instagram','about_us','welcome_text','title','sub_welcome_text'];


    public function getBackgroundImageAttribute()
    {
        return asset('uploads/webpage/bg.png');
    }


    public function getLogoAttribute()
    {
        return asset('uploads/webpage/logo.png');
    }


    public function getFaviconAttribute()
    {
        return asset('uploads/webpage/favicon.png');
    }

}
