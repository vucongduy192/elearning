<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        $avatar = storage_path(str_replace('/storage/', 'app/public/', $user->avatar));
        $placeholder = '/images/image_placeholder.png';

        return [
            'id' => $user->id,
            'name' => $user->name, 
            'email' => $user->email, 
            'avatar' =>  (file_exists($avatar) && $user->avatar) ? $user->avatar : $placeholder,
            'role' => $user->getRole(),
            'teacher_id' => $user->teacher ? $user->teacher->id : null,
        ];
    }
}