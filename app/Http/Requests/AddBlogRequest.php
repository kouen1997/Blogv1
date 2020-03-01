<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddBlogRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        return [
            'title' => 'required',
            'category' => 'required',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'content' => 'required|min:100'
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}