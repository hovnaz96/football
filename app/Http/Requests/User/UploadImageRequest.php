<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UploadImageRequest extends FormRequest
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
            'file' => 'mimes:gif,png,jpg|max:8000',
            'files' => 'mimes:gif,png,jpg|max:8000'
        ];

        $types = ['jpg','gif','png'];
        if($request->file('files')){
            foreach ($request->file('files') as $file){
                if(in_array($file->getClientOriginalExtension(),$types)){
                    return [];
                }

                return $rules;
            }

        }else if($this->get( 'files' )){
            foreach ($request->file('file') as $file) {
                if (in_array($file->getClientOriginalExtension(), $types)) {
                    return [];
                }

                return $rules;
            }
        }

        return [];

    }
}
