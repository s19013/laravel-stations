<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Validator;

use Illuminate\Validation\Validator;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() { return true; }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'movie_id'  => 'required',
            'screen_id' => 'required|max:3',
            'start_time_date' => 'required|date|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date'   => 'required|date|date_format:Y-m-d',
            'end_time_time'   => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'movie_id.required'  => 'idがない',
            'screen_id.required' => '入力してください',
            'screen_id.max'      => '最大値は3までです',
            'start_time_date.required'    => '入力してください',
            'start_time_date.date_format' => '年-月-日の形式で入力してください',
            'start_time_time.required'    => '入力してください',
            'start_time_time.date_format' => '時間:分の形式で入力してください',
            'end_time_date.required'      => '入力してください',
            'end_time_date.date_format'   => '年-月-日の形式で入力してください',
            'end_time_time.required'      => '入力してください',
            'end_time_time.date_format'   => '時間:分の形式で入力してください',
        ];
    }
}
