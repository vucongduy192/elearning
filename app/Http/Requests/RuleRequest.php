<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuleRequest extends FormRequest
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
            'cat_id1' => 'required',
            'cat_id2' => 'required',
            'weight' => 'required|numeric|min:0.1|max:1',
        ];
    }

    public function messages()
    {
        return [
            'cat_id1.unique' => 'That rule is existed',
        ];
    }
}
