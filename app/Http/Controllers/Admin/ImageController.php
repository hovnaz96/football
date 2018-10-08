<?php

namespace App\Http\Controllers\Admin;

use App\Models\UsersImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = UsersImage::with(['user'])->withCount('imageLike')->get();
        return view('admin.image',compact('images'));
    }


    public function most()
    {
        $images = UsersImage::with(['user'])->withCount('imageLike')->orderBy('views','DESC')->get();
        return view('admin.image',compact('images'));
    }


    public function latest()
    {
        $images = UsersImage::with(['user'])->withCount('imageLike')->orderBy('created_at','DESC')->get();
        return view('admin.image',compact('images'));
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
        $image = UsersImage::where('id',$id)->first();

        if(file_exists($image->delete_image_original)){
            File::delete($image->delete_image_original);
        }

        if(file_exists($image->delete_image_small)){
            File::delete($image->delete_image_small);
        }
        $delete = $image->delete();

        return response()->json(['success'=>$delete]);
    }
}
