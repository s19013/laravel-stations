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
    public function authorize()
    {
        // 通信メソッドで制限
        // 今回の仕様ではURLで制限をかけるのは難しいと判断
        $validityList = [
            'PATCH',
            'POST'
        ];

        if (in_array($this->method(), $validityList )) { return true; }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // そもそもなんでチェックボックスにこだわるんだよトグルとか､ラジオボタンで十分でしょ!!
        // 2バイトトラップの処理とかあるけど今回はそういうの無視

        $baseRules = [
            'movie_id' => 'required',
            'start_time_date' => 'required|date|date_format:Y-m-d',
            'start_time_time' => 'required|date_format:H:i',
            'end_time_date'   => 'required|date|date_format:Y-m-d',
            'end_time_time'   => 'required|date_format:H:i',
        ];

        if ($this->method()==="PATCH") { $baseRules["schedule_id"] = 'required'; }
        return $baseRules;
    }

    public function messages()
    {
        return [
            'movie_id.required' => 'idがない',
            'schedule_id.required' => 'idがない',
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
