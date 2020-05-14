<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        $thumbnail = storage_path(str_replace('/storage/', 'app/public/', $category->thumbnail));
        $placeholder = '/images/image_placeholder.png';

        return [
            'id' => $category->id,
            'name' => $category->name,
            'overview' => $category->overview,
            'thumbnail' =>  (file_exists($thumbnail) && $category->thumbnail) ? $category->thumbnail : $placeholder,
        ];
    }
}
