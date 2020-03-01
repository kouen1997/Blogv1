<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AdduserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|max:255|unique:tbl_users,email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}