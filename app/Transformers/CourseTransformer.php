<?php

namespace App\Transformers;

use App\Models\Course;
use League\Fractal\TransformerAbstract;

class CourseTransformer extends TransformerAbstract
{
    public function transform(Course $course)
    {
        $thumbnail = storage_path(str_replace('/storage/', 'app/public/', $course->thumbnail));
        $placeholder = '/images/image_placeholder.png';

        return [
            'id' => $course->id,
            'name' => $course->name, 
            'overview' => $course->overview, 
            'price' => $course->price,
            'enrolls' => $course->enrolls,
            'courses_category_id' => $course->courses_category_id,
            'courses_category' => $course->courses_category->name,
            'level' => $course->level,
            'thumbnail' =>  (file_exists($thumbnail) && $course->thumbnail) ? $course->thumbnail : $placeholder,
            'teacher' => $course->teacher,
            'teacher_id' => $course->teacher_id,
            'lectures' => $course->lectures,
        ];
    }
}