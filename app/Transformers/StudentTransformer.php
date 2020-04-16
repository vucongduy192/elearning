<?php

namespace App\Transformers;

use App\Models\Student;
use League\Fractal\TransformerAbstract;

class StudentTransformer extends TransformerAbstract
{
    public function transform(Student $student)
    {
        $avatar = storage_path(str_replace('/storage/', 'app/public/', $student->avatar));
        $placeholder = '/images/image_placeholder.png';

        return [
            'id' => $student->id,
            'name' => $student->name, 
            'email' => $student->email, 
            'school' => $student->school,
            'major' => $student->major,
            'avatar' =>  (file_exists($avatar) && $student->avatar) ? $student->avatar : $placeholder,
        ];
    }
}