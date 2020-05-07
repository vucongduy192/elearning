<?php

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\BaseRepository;
use App\Traits\TransformPaginatorTrait;
use App\Transformers\ReviewTransformer;
use Illuminate\Http\Request;

class ReviewRepository {
    use BaseRepository, TransformPaginatorTrait;
    protected $model, $reviewTransformer;

    /**
     * ReviewRepository constructor.
     * @param Review $review
     */
    public function __construct(Review $review, ReviewTransformer $reviewTransformer)
    {
        $this->model = $review;
        $this->reviewTransformer = $reviewTransformer;
    }

    public function filterReview($course_id)
    {
        $sortType = 'desc';
        $sortColumn = 'created_at';
        $number = 3;
        return $this->model->where('course_id', $course_id)
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);
    }
}
