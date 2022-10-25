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
            'screen_id' => 'required|numeric|max:3|min:1',
            'start_time_date' => 'required|date|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date'   => 'required|date|date_format:Y-m-d',
            'end_time_time'   => 'required|date_format:H:i',
        ];
    }

    // 型をととのえる
    public function validated()
    {
        // バリデーションチェックを通ったデータだけ取得
	    $validated = $this->validator->validated();
	    // キャストしたデータをarra_mergeで上書き
        return array_merge($validated,[
            "movie_id"  => (integer)$this->movie_id,
            "screen_id" => (integer)$this->screen_id,
        ]);
    }

    public function messages()
    {
        return [
            'movie_id.required'  => 'idがない',
            'screen_id.required' => '入力してください',
            'screen_id.numeric'  => '数値を入力してください',
            'screen_id.max'      => '最大値は3までです',
            'screen_id.min'      => '最小値は1までです',
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
