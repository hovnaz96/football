<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebSiteSettings;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $settings = WebSiteSettings::first();
        return view('admin.settings',compact('settings'));
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
    public function update(Request $request)
    {
        $update = WebSiteSettings::where('id',1)->update($request->except('_token','logo','favicon','background'));
        if($update)
        {
            if(!empty($request->file('logo'))){
                $logo = $request->file('logo');
                $resize = Image::make($logo)->resize(121,37)->encode('png');
                $path = public_path('uploads/webpage/logo.png');
                $resize->save($path);
            }
            if(!empty($request->file('background'))){
                $bg = $request->file('background');
                $resize = Image::make($bg)->encode('png');
                $path = public_path('uploads/webpage/bg.png');
                $resize->save($path);
            }
            if(!empty($request->file('favicon'))){
                $favicon = $request->file('favicon');
                $resize = Image::make($favicon)->fit(32)->encode('png');
                $path = public_path('uploads/webpage/favicon.png');
                $resize->save($path);
            }

            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
