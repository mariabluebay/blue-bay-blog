<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|unique:posts|string|max:255',
            'excerpt' => 'required|max:255',
            'body' => 'required',
            'active' => 'required|boolean',
            'audience' => 'required',
            'featured' => 'nullable|image'
        ];
    }
}