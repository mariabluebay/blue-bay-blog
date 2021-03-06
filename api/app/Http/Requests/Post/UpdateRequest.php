<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'excerpt' => 'required|max:255',
            'body' => 'required',
            'active' => 'required|boolean',
            'audience' => 'required|string',
            'featured' => 'nullable|image'
        ];
    }
}
