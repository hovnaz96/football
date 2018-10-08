<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ImageLike;
use App\Models\User;
use App\Models\UsersImage;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{

    protected $ERROR_STATUS_CODE = 400;
    protected $ERROR_VALIDATE_CODE = 422;
    protected $SUCCESS_STATUS_CODE = 200;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = UsersImage::with('user')->withCount('imageLike')->orderBy('views','DESC')->limit(10)->get();
        $videos = Video::with('user')->withCount('videoLikes')->orderBy('views','DESC')->limit(10)->get();
        return view('home.index',compact('images','videos'));
    }


    public function videos()
    {
        $videos = Video::with('user')->withCount('videoLikes')->orderBy('created_at','DESC')->get();
        return view('home.videos',compact('videos'));
    }

    public function photos()
    {
        $images = UsersImage::with('user')->withCount('imageLike')->orderBy('created_at','DESC')->get();
        return view('home.photos',compact('images'));
    }

    public function users()
    {
        $users = User::orderBy('created_at','DESC')->get();
        return view('home.users',compact('users'));
    }



    public function imageView(Request $request)
    {
        $response  = new Response();

        if($request->ajax())
        {
            $update = UsersImage::where('id',$request->input('image_id'))->increment('views');

            if($update){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }

    public function videoView(Request $request)
    {
        $response  = new Response();

        if($request->ajax())
        {
            $update = Video::where('id',$request->input('video_id'))->increment('views');

            if($update){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }
}
