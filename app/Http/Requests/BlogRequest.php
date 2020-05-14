<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $rules_store = [
            'title' => 'required|unique:blogs',
            'summary' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'content' => 'required',
        ];
        $rules_update = [
            'title' => 'required|unique:blogs,title,'.$this->route('blog'),
            'summary' => 'required',
            'content' => 'required',
        ];
        
        return ($this->getMethod() == 'POST') ? $rules_store : $rules_update;
    }
}
