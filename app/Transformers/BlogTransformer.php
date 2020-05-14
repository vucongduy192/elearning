<?php

namespace App\Transformers;

use App\Models\Blog;
use League\Fractal\TransformerAbstract;

class BlogTransformer extends TransformerAbstract
{
    public function transform(Blog $blog)
    {
        $thumbnail = storage_path(str_replace('/storage/', 'app/public/', $blog->thumbnail));
        $placeholder = '/images/image_placeholder.png';

        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'thumbnail' =>  (file_exists($thumbnail) && $blog->thumbnail) ? $blog->thumbnail : $placeholder,
            'summary' => $blog->summary,
            'content' => $blog->content,
        ];
    }
}
