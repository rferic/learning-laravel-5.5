<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ValidReply;

class ReplyRequest extends FormRequest
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

    public function rules()
    {
        return [
            'post_id' => 'required|exists:posts,id',
            'title' => 'required|unique:posts|max:100',
            // TODO Use Rules for validate
            'reply' => ['required', new ValidReply],
            'file' => 'image'
        ];
    }

    public function messages ()
    {
        return [
            'post_id.required' => 'Post not found',
            'post_id.exists' => 'Post not exists',
            'name.required' => __('Name is required'),
            'name.max' => __('Name only accept 100 characters'),
            'name.unique' => __('This post already exists'),
            'reply.required' => __('Reply is required'),
            'file.image' => __('File is not a image')
        ];
    }
}
