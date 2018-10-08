<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SocialLinksRequest extends FormRequest
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
    public function rules()
    {
        return [
            'facebook' => [
                            'nullable',
                            'regex:/^(((http|https):\/\/|)(www\.|)facebook\.com\/[a-zA-Z0-9.]{1,})$/',
            ],
            'twitter' => [
                            'nullable',
                            'regex:/^(https?:\/\/)?(www\.)?twitter\.com\/[A-Za-z0-9_]{5,15}(\?(\w+=\w+&?)*)?$/'
            ],
            'google_plus' => [
                                'nullable',
                                'regex:/^(((https?:\/\/)?(plus\.)?google\.com(\/u\/\d)?\/\+?([^\/\s]+)\/?))$/'
            ],
            'instagram' => [
                            'nullable',
                            'regex:/^((https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9_.]{1,30}\/?)$/'
            ],
        ];
    }
}
