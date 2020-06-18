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
            'name_en' => 'required|unique:courses',
            'overview' => 'required',
            'price' => 'required',
            'level' => 'required',
            'courses_category_id' => 'required',
            'duration_id' => 'required',
            'partner_id' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'modules.*.name' => 'required',
            'modules.*.overview' => 'required',
        ];
        $rules_update = [
            'name' => 'required|unique:courses,name,'.$this->route('course'),
            'name_en' => 'required|unique:courses,name_en,'.$this->route('course'),
            'overview' => 'required',
            'price' => 'required',
            'level' => 'required',
            'courses_category_id' => 'required',
            'duration_id' => 'required',
            'partner_id' => 'required',
            'modules.*.name' => 'required',
            'modules.*.overview' => 'required',
        ];
        
        return ($this->getMethod() == 'POST') ? $rules_store : $rules_update;
    }
}
