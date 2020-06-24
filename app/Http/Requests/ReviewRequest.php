<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'content' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'course_id' => 'required',
            'student_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Hãy nhập nội dung đánh gái',
            'rating.required'  => 'Hãy chọn số star',
            'rating.min' => 'Chọn số star lớn hơn hoặc bằng 1',
            'rating.max' => 'Chọn số star nhỏ hoặc bằng 5'
        ];
    }
}
