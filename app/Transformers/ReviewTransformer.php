<?php

namespace App\Transformers;

use App\Models\Review;
use League\Fractal\TransformerAbstract;

class ReviewTransformer extends TransformerAbstract
{
    public function transform(Review $review)
    {
        return [
            'id' => $review->id,
            'content' => $review->content,
            'rating' => $review->rating,
            'course_id' => $review->course_id,
            'student_id' => $review->student_id,
            'student' => $review->student->user->name,
            'avatar' => $review->student->user->avatar,
        ];
    }
}
