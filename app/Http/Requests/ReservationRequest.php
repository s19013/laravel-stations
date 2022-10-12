<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Validator;

use Illuminate\Validation\Validator;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {return true; }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'movie_id' => 'required',
            'name'     =>'required|max:255',
            'email'    =>'required|max:255|email',
            "schedule_id" =>'required',
            "screening_date" =>'required',
            "sheet_id" =>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'  =>'入力してください',
            'name.max'       =>'120文字以内',
            'email.required' =>'入力してください',
            'email.max'   =>'255文字以内',
            'email.email' =>'メアドを入力',
        ];
    }
}

