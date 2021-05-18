<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|min:3|max:50|unique:users,username,'.$this->user->id,
            'name' => 'string|required|max:255',
            'avatar' => 'nullable|file',
            'cover' => 'nullable|file',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->user->id,
            'password' => 'password|required|min:8|max:255'
        ];
    }
}
