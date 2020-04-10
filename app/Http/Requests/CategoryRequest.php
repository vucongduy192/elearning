<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
    public function rules($id=null)
    {
        $rules_store = [
            'name' => 'required|unique:course_categories',
            'overview' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $rules_update = [
            'name' => 'required|unique:course_categories,name,'.$this->route('category'),
            'overview' => 'required',
        ];
        
        return ($this->getMethod() == 'POST') ? $rules_store : $rules_update;
    }
}
