<?php

namespace App\Transformers;

use App\Models\Enroll;
use App\Models\Category;
use League\Fractal\TransformerAbstract;

class EnrollTransformer extends TransformerAbstract
{
    public function transform(Enroll $enroll)
    {
        return [
            'id' => $enroll->id,
            'course_name' => $enroll->course_name,
            'username' => $enroll->username,
            'email' => $enroll->email,
            'courses_category_id' => $enroll->courses_category_id,
            'courses_category' => $enroll->course->courses_category->name,
        ];
    }
}