<?php

namespace App\Http\Controllers\Home\User;

use App\Http\Requests\User\BasicInfoRequest;
use App\Http\Requests\User\DescriptionRequest;
use App\Http\Requests\User\PasswordUpdateRequest;
use App\Http\Requests\User\SocialLinksRequest;
use App\Models\Country;
use App\Models\ImageLike;
use App\Models\PersonalInformation;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserFollowers;
use App\Models\UsersImage;
use App\Models\Video;
use App\Models\VideoLike;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $ERROR_STATUS_CODE = 400;
    protected $ERROR_VALIDATE_CODE = 422;
    protected $SUCCESS_STATUS_CODE = 200;

    public function  __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('user/profile');
    }

    public function edit()
    {
        $countries = Country::select('id','citizenship')->orderBy('citizenship','ASC')->get();
        $user = User::with(['personal_info'=>function($query){
                    $query->with('country')->first();
                }])
                ->where('id',\Auth::user()->id)
                ->first();

        return view('home/user/edit',compact('countries','user'));
    }


    public function basicInfoUpdate(BasicInfoRequest $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $auth_id = Auth::user()->id;
            $user = User::where('id',$auth_id)->update([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'day' => $request->input('day'),
                'month' => $request->input('month'),
                'year' => $request->input('year')
            ]);

            if($user){
                $personal_info = PersonalInformation::where('user_id',$auth_id)->update($request->except(['firstname','lastname','_token','day','month','year']));
                if($personal_info){
                    return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
                }
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $auth_id = Auth::user()->id;
            $user =  User::where('id',$auth_id)->first();
            if(Hash::check($request->input('old_password'),$user->password))
            {
                if(Hash::check($request->input('password'), $user->password)){
                    return response()->json(['password'=>['0'=>'This is a old password please enter new password.']])->setStatusCode($this->ERROR_VALIDATE_CODE);
                }else{
                    $update = $user->update(['password'=>bcrypt($request->input('password'))]);
                }
            }else{
                return response()->json(['old_password'=>['0'=>'The old password does not match.']])->setStatusCode($this->ERROR_VALIDATE_CODE);
            }


            if($update)
            {
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }


    public function updateSocialLinks(SocialLinksRequest $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $auth_id = Auth::user()->id;
            $update = PersonalInformation::where('user_id',$auth_id)->update($request->except(['_token']));
            if($update)
            {
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }

    public function updateDescription(DescriptionRequest $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $auth_id = Auth::user()->id;
            $update = PersonalInformation::where('user_id',$auth_id)->update($request->except(['_token']));
            if($update)
            {
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }

            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }


    public function userProfile($slug)
    {
            $user_check =  User::select(['id','firstname','lastname'])->where('slug',$slug);
            if($user_check->count()) {
                $user = $user_check->with(['followersRelation' => function ($query) {
                    $query->select(['follower_id', 'user_id'])->with('userFollowing');
                }, 'followingRelation' => function ($query) {
                    $query->select(['follower_id', 'user_id'])->with('userFollowers');
                }, 'personal_info' => function ($query) {
                    $query->select(['occupation', 'description', 'user_id']);
                }])->withCount(['followingRelation', 'followersRelation'])->first();

                $ids = UsersImage::select(['id','views'])->where('user_id', $user->id)->get();
                $ids_video = Video::select(['id','views'])->where('user_id', $user->id)->get();
                $likes_photo = ImageLike::whereIn('image_id', $ids->pluck('id')->toArray())->count();
                $likes_video = VideoLike::whereIn('video_id', $ids_video->pluck('id')->toArray())->count();
                $likes = $likes_photo + $likes_video;
                $views = $ids->sum('views') + $ids_video->sum('views');
                if (!$user) {
                    abort(404);
                }

                return view('home/user/view_profile', compact('user', 'likes','views'));
            }else{
                abort(404);
            }

    }


    public function userFollow(Request $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $id_auth = Auth::user()->id;
            $follower_id = $request->input('follower_id');
            $check = UserFollowers::where('user_id',$id_auth)->where('follower_id',$follower_id)->count();
            if(!$check){
                $follow_unfollow = UserFollowers::create([
                    'user_id'=>$id_auth,
                    'follower_id'=>$follower_id,
                ]);
            }else{
                $follow_unfollow = UserFollowers::where([
                    'user_id'=>$id_auth,
                    'follower_id'=>$follower_id,
                ])->delete();
            }

            if($follow_unfollow){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }
            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }



    public function userLikeImage(Request $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $id_auth = Auth::user()->id;
            $image_id = $request->input('image_id');
            $is = ImageLike::where('user_id',Auth::user()->id)->where('image_id','=',$image_id)->count();
            if(!$is)
            {
                $like_unlike = ImageLike::create([
                    'user_id'=>$id_auth,
                    'image_id'=>$image_id,
                ]);
            }else{
                $like_unlike = ImageLike::where([
                    'user_id'=>$id_auth,
                    'image_id'=>$image_id,
                ])->delete();
            }

            if($like_unlike){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }
            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }

    public function userLikeVideo(Request $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $id_auth = Auth::user()->id;
            $video_id = $request->input('video_id');
            $is = VideoLike::where('user_id',Auth::user()->id)->where('video_id','=',$video_id)->count();
            if(!$is)
            {
                $like_unlike = VideoLike::create([
                    'user_id'=>$id_auth,
                    'video_id'=>$video_id,
                ]);
            }else{
                $like_unlike = ImageLike::where([
                    'user_id'=>$id_auth,
                    'video_id'=>$video_id,
                ])->delete();
            }

            if($like_unlike){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }
            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }


    public function userDeleteImage(Request $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $id_auth = Auth::user()->id;
            $image_id = $request->input('image_id');
            $image = UsersImage::where('id',$image_id)->first();
            if($image->user_id == $id_auth) {
                $delete = $image->delete();
                $file_small = public_path('uploads/users/'.$id_auth.'/'.$image->id.'_small.png');
                $file_original = public_path('uploads/users/'.$id_auth.'/'.$image->id.'_original.png');
                if(file_exists($file_small)){
                    File::delete($file_small);
                }
                if(file_exists($file_original)){
                    File::delete($file_original);
                }
            }else{
                $delete = false;
            }


            if($delete){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }
            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }

    public function userDeleteVideo(Request $request)
    {
        $response  = new Response();
        if($request->ajax())
        {
            $id_auth = Auth::user()->id;
            $video_id = $request->input('video_id');
            $video = Video::where('id',$video_id)->first();
            if($video->user_id == $id_auth) {
                $delete = $video->delete();
                $file_video = public_path('uploads/videos/'.$id_auth.'/'.$video->id.'_video.'.$video->extension);
                $file_thumbnail = public_path('uploads/videos/thumbnails/'.$video->id.'_thumbnail.jpg');
                if(file_exists($file_video)){
                    File::delete($file_video);
                }
                if(file_exists($file_thumbnail)){
                    File::delete($file_thumbnail);
                }
            }else{
                $delete = false;
            }


            if($delete){
                return $response->setStatusCode($this->SUCCESS_STATUS_CODE);
            }
            return $response->setStatusCode($this->ERROR_STATUS_CODE);
        }

        return $response->setStatusCode($this->ERROR_STATUS_CODE);
    }


}
