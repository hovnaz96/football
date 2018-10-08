<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function __construct()
    {

    }

    public function videos()
    {
        return view('user/videos');
    }
}
