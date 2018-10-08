<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UploadVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'files' => 'nullable|mimes:video/mp4,video/x-flv,video/MP2T,application/x-mpegURL,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:32000'
        ];

        if($request->file('file')){
            $videos = $this->get( 'files' );

            if ( !empty( $videos ) )
            {
                foreach ( $videos as $key => $video ) // add individual rules to each image
                {
                    $rules[ sprintf( 'images.%d', $key ) ] = 'required|video';
                }
            }

            return $rules;
        }


        return [];

    }
}
