<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
// use Validator;

use Illuminate\Validation\Validator;

class MovieRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // そもそもなんでチェックボックスにこだわるんだよトグルとか､ラジオボタンで十分でしょ!!
        // 2バイトトラップの処理とかあるけど今回はそういうの無視
        return [
            // 自分以外に同じタイトルがないか
            'title'       => ['required', 'max:220', Rule::unique('movies')->ignore($this->id)],
            'image_url'   => 'required|url',
            'description' => 'required',
            'is_showing'  => 'required',
            'published_year' => 'required|numeric',
        ];
    }

    // 型をととのえる
    public function validated()
    {
        // バリデーションチェックを通ったデータだけ取得
	    $validated = $this->validator->validated();
	    // キャストしたデータをarra_mergeで上書き
        return array_merge($validated,[
            "is_showing" =>(boolean)$this->is_showing,
            "published_year"    =>(integer)$this->published_year,
        ]);
    }

    // public function withValidator(Validator $validator)
    // {
    //     // 新規
    //     $validator->sometimes('title',['required', 'max:220', 'unique:movies'] , function ($input) {
    //         return $this->method() == 'POST';
    //     });

    //     // 更新
    //     $validator->sometimes('title',['required', 'max:220', Rule::unique('movies')->ignore($this->id)] , function ($input) {
    //         return $this->method() == 'PATCH';
    //     });
    // }

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
