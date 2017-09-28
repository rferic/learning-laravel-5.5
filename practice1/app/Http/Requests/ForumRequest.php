<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        //return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100|unique:forums',
            'description' => 'required'
        ];
    }

    public function messages ()
    {
        return [
            'name.required' => __('Name is required'),
            'name.max' => __('Name only accept 100 characters'),
            'name.unique' => __('This forum already exists'),
            'description.required' => __('Description is required')
        ];
    }
}
