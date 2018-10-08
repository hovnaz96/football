<?php

namespace App\Http\Controllers\Admin;

use App\Models\ImageLike;
use App\Models\Message;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Models\UserFollowers;
use App\Models\UsersImage;
use App\Models\Video;
use App\Models\VideoLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('admin.users',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $user = User::where('slug',$slug)->first();

        return view('admin.user-edit',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if(is_null($request->input('password'))){
            User::where('slug',$slug)->update($request->except(['_token','_method','password']));

            return redirect()->back();
        }

        User::where('slug',$slug)->update($request->except(['_token','_method']));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $images = UsersImage::where('user_id',$id)->get();

        foreach ($images as $image)
        {
            if(file_exists($image->delete_image_original)){
                File::delete($image->delete_image_original);
            }

            if(file_exists($image->delete_image_small)){
                File::delete($image->delete_image_small);
            }

        }

        UsersImage::where('user_id',$id)->delete();
        ImageLike::where('user_id',$id)->delete();



        $videos = Video::where('user_id',$id)->get();

        foreach ($videos as $video)
        {
            if(file_exists($video->delete_video_url)){
                File::delete($video->delete_video_url);
            }

            if(file_exists($video->delete_thumbnail_name)){
                File::delete($video->delete_thumbnail_name);
            }
        }

        Video::where('user_id',$id)->delete();
        VideoLike::where('user_id',$id)->delete();
        UserFollowers::where('user_id',$id)->orWhere('follower_id',$id)->delete();
        PersonalInformation::where('user_id',$id)->delete();
        Message::where('from_id',$id)->orWhere('to_id',$id)->delete();

        User::where('id',$id)->delete();

        return response()->json(['success'=>true]);
    }


    public function newUsers()
    {
        $users = User::orderBy('id','DESC')->get();
        return view('admin.users',compact('users'));
    }
}
