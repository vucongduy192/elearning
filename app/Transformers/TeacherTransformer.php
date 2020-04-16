<?php

namespace App\Transformers;

use App\Models\Teacher;
use League\Fractal\TransformerAbstract;

class TeacherTransformer extends TransformerAbstract
{
    public function transform(Teacher $teacher)
    {
        $avatar = storage_path(str_replace('/storage/', 'app/public/', $teacher->avatar));
        $placeholder = '/images/image_placeholder.png';

        return [
            'id' => $teacher->id,
            'name' => $teacher->name, 
            'email' => $teacher->email, 
            'workplace' => $teacher->workplace,
            'expert' => $teacher->expert,
            'avatar' =>  (file_exists($avatar) && $teacher->avatar) ? $teacher->avatar : $placeholder,
        ];
    }
}