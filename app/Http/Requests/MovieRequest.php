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
        // 一部urlでのみ有効
        $validityList = [
            'admin/movies/store',
        ];

        if (in_array($this->path(), $validityList )) { return true; }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'       => 'required',
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
            'image_url.required'   => '入力してください',
            'image_url.url'        => 'urlを入力してください',
            'description.required' => '入力してください',
            'is_showing.required'  => '入力してください',
            'published_year.required' => '入力してください',
        ];
    }
}
