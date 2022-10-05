<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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

        // 2バイトトラップの処理とかあるけど今回はそういうの無視
        return [
            'title'       => 'required|unique:movies|max:220',
            'image_url'   => 'required|url',
            'description' => 'required',
            'is_showing'  => 'required',
            'published_year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'       => '入力してください',
            'title.unique'         => 'そのタイトルの映画はすでに登録されています',
            'title.max'            => '120文字いないで入力',
            'image_url.required'   => '入力してください',
            'image_url.url'        => 'urlを入力してください',
            'description.required' => '入力してください',
            'is_showing.required'  => '入力してください',
            'published_year.required' => '入力してください',
        ];
    }
}
