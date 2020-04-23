<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'name' => 'required|unique:courses',
            'overview' => 'required',
            'price' => 'required',
            'level' => 'required',
            'courses_category_id' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'lectures.*.name' => 'required',
            'lectures.*.slide' => 'required',
        ];
        $rules_update = [
            'name' => 'required|unique:courses,name,'.$this->route('course'),
            'overview' => 'required',
            'price' => 'required',
            'level' => 'required',
            'courses_category_id' => 'required',
            'lectures.*.name' => 'required',
            'lectures.*.slide' => 'required',
        ];
        
        return ($this->getMethod() == 'POST') ? $rules_store : $rules_update;
    }
}
