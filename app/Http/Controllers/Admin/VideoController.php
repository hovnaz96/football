<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::with(['user'])->withCount('videoLikes')->get();
        return view('admin.videos',compact('videos'));
    }


    public function most()
    {
        $videos = Video::with(['user'])->withCount('videoLikes')->orderBy('views','DESC')->get();
        return view('admin.videos',compact('videos'));
    }

    public function latest()
    {
        $videos = Video::with(['user'])->withCount('videoLikes')->orderBy('created_at','DESC')->get();
        return view('admin.videos',compact('videos'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Video::where('id',$id)->first();

        if(file_exists($video->delete_video_url)){
            File::delete($video->delete_video_url);
        }

        if(file_exists($video->delete_thumbnail_name)){
            File::delete($video->delete_thumbnail_name);
        }
        $delete = $video->delete();

        return response()->json(['success'=>$delete]);
    }
}
