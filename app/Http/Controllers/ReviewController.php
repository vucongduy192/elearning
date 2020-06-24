<?php

namespace App\Http\Controllers;

use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\View;

class ReviewController extends Controller
{
    protected $review;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->review = $reviewRepository;
    }

    public function index($course_id)
    {
        $reviews = $this->review->filterReview($course_id);
        return $this->response([
            'html' => View::make('components.reviews_list')->with(['reviews' => $reviews])->render()
        ]);
    }

    public function store(ReviewRequest $request)
    {
        $input = $request->only('content', 'rating', 'course_id', 'student_id');
        $this->review->store($input);
        return $this->response([
            'message' => 'Lưu đánh giá thành công'
        ]);
    }
}
