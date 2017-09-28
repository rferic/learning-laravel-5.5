<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'forum_id' => 'required|exists:forums,id',
            'title' => 'required|unique:posts|max:100',
            'description' => 'required',
            'file' => 'image'
        ];
    }

    public function messages ()
    {
        return [
            'forum_id.required' => 'Forum not found',
            'forum_id.exists' => 'Forum not exists',
            'name.required' => __('Name is required'),
            'name.max' => __('Name only accept 100 characters'),
            'name.unique' => __('This post already exists'),
            'description.required' => __('Description is required'),
            'file.image' => __('Attachment is not a image')
        ];
    }
}
