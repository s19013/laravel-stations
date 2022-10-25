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
    public function authorize() {return true;}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "schedule_id" =>'required',
            "screening_date" =>'required|date|date_format:Y-m-d',
            "sheet_id" =>'required',
            "user_id" =>'required',
        ];
    }

    // 型をととのえる
    public function validated()
    {
        // バリデーションチェックを通ったデータだけ取得
	    $validated = $this->validator->validated();
	    // キャストしたデータをarra_mergeで上書き
        return array_merge($validated,[
            "schedule_id" =>(integer)$this->schedule_id,
            "sheet_id"    =>(integer)$this->sheet_id,
            "user_id"     =>(integer)$this->user_id,
        ]);
    }

    public function messages()
    {
        return [
            "schedule_id.required" => "入力してください",
            "screening_date.required" => "入力してください",
            "screening_date.date_format" => "年-月-日形式で入力してください",
            "sheet_id.required" => "入力してください",
            "user_id.required" => "入力してください",
        ];
    }
}

