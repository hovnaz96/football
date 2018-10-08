<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BasicInfoRequest extends FormRequest
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
        $date_of_birth = $request->input('day').'-'.$request->input('month').'-'.$request->input('year');
        $request->request->add(['data_of_birth'=>$date_of_birth]);
        $current_year          = Carbon::now()->year;
        $years_ago             = (new Carbon("116 years ago"))->year;

        $validator = Validator::make($request->all() ,[
            'firstname' => 'required',
            'lastname' =>  'required',
            'occupation' => 'nullable||max:40',
            'city' => 'nullable|max:40',
            'country_id' => 'required|numeric|exists:countries,id',
            'year'          => 'required|Integer|Between:'.$years_ago.','.$current_year,
            'data_of_birth' => 'required|Date',
        ])->validate();

        if(is_null($validator)){
            return [];
        }

        return $validator;
    }
}
