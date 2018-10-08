<?php

namespace App\Http\Controllers\Home\User;

use App\Http\Requests\User\UploadVideoRequest;
use App\Http\Requests\User\UploadImageRequest;
use App\Models\UsersImage;
use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Lakshmaji\Thumbnail\Facade\Thumbnail;

class FileController extends Controller
{

    protected $ERROR_STATUS_CODE = 400;
    protected $ERROR_VALIDATE_CODE = 422;
    protected $SUCCESS_STATUS_CODE = 200;

    public function  __construct()
    {
        $this->middleware('auth');
    }



    public function uploadProfileImage(UploadImageRequest $request)
    {
        $response  = new Response();
        if($request->ajax()){
            if(!empty($request->file())){
                $id = Auth::user()->id;
                $file = $request->file('file');
                $resize_small = Image::make($file)->fit(40)->encode('png');
                $resize_medium = Image::make($file)->fit(80)->encode('png');
                $resize_large = Image::make($file)->fit(160)->encode('png');
                $small_path = public_path('uploads/users_profile/'.$id.'_small.png');
                $medium_path = public_path('uploads/users_profile/'.$id.'_medium.png');
                $large_path = public_path('uploads/users_profile/'.$id.'_large.png');

                $small = $resize_small->save($small_path);
                $medium = $resize_medium->save($medium_path);
                $large = $resize_large->save($large_path);

                if($small && $medium && $large){
                    return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
                }
                return $response->setStatusCode($this->ERROR_STATUS_CODE);
            }
            return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
        }
        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }


    public  function uploadImages(UploadImageRequest $request){
        $response  = new Response();
        if($request->ajax()){
            if(!empty($request->file())){
                $id = Auth::user()->id;
                $files = $request->file('files');
                foreach ($files as $file){
                    $id_image = UsersImage::create(['user_id'=>$id])->id;
                    $resize_small = Image::make($file)->fit(251)->encode('png');
                    $resize_original = Image::make($file)->encode('png');
                    if (!file_exists(public_path('uploads/users/'.$id))) {
                        mkdir(public_path('uploads/users/'.$id), 0777, true);
                    }
                    $original_path = public_path('uploads/users/'.$id.'/'.$id_image.'_original.png');
                    $small_path = public_path('uploads/users/'.$id.'/'.$id_image.'_small.png');
                    $small = $resize_small->save($small_path);
                    $original = $resize_original->save($original_path);
                }
                if($small && $original){
                    return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
                }
                return $response->setStatusCode($this->ERROR_STATUS_CODE);
            }
            return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
        }
        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }

    public  function uploadVideos(UploadVideoRequest $request){
        $response  = new Response();
        if($request->ajax()){
            if(!empty($request->file())){
                $id = Auth::user()->id;
                $files = $request->file('files');
                $success = $this->ERROR_STATUS_CODE;
                foreach ($files as $file){
                    $extension_type   = $file->getClientOriginalExtension();
                    $video_id = Video::create(['user_id'=>$id,'extension'=>$extension_type])->id;

                    $destination_path = public_path('uploads/videos/'.$id);
                    $file_name        = $video_id.'_video.'.$extension_type;

                    $upload_status    = $file->move($destination_path, $file_name);

                    if($upload_status)
                    {
//                        // file type is video
//                        // set storage path to store the file (image generated for a given video)
//                        $thumbnail_path   = public_path('uploads/videos/thumbnails');
//
//                        $video_path       = $destination_path.'/'.$file_name;
//
//                        // set thumbnail image name
//                        $thumbnail_image  = $video_id.'_thumbnail'.".jpg";
//
//
//
////                        // set the thumbnail image "palyback" video button
////                        $water_mark       = storage_path().'/watermark/p.png';
//
//                        // get video length and process it
//                        // assign the value to time_to_image (which will get screenshot of video at that specified seconds)
//                        $time_to_image    = floor(1);
//
//
//                        $thumbnail_status = Thumbnail::getThumbnail(str_replace('\\','/',$video_path),str_replace('\\','/',$thumbnail_path),$thumbnail_image,$time_to_image);
//
//                        if($thumbnail_status)
//                        {
//                            $success = $this->SUCCESS_STATUS_CODE;
//                        }
                        $success = $this->SUCCESS_STATUS_CODE;
                    }
                }
                return $response->setStatusCode($success);
            }
            return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
        }
        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }


    public function uploadVideoThumbnail(UploadImageRequest $request,$id)
    {
        $response  = new Response();
        if($request->ajax())
        {
            if(!empty($request->file())) {
                $file = $request->file('file');
                $thumbnail_image  = $id.'_thumbnail'.'.jpg';
                $thumbnail_path   = public_path('uploads/videos/thumbnails/').$thumbnail_image;

                $image = Image::make($file)->fit(328,240)->encode('jpg')->save($thumbnail_path);
                if($image)
                {
                    return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
                }
                return $response->setStatusCode($this->ERROR_STATUS_CODE);
            }
            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }
        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }
}
