<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
{
    protected $blog;

    /**
     * BlogController constructor.
     * @param BlogRepository $blogRepository
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blog = $blogRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('pages.blogs');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $number = 4;
        $blogs = $this->blog->filterBlog($number);

        return $this->response([
            'html' => View::make('components.blogs_list')->with(['blogs' => $blogs])->render()
        ]);
    }

    public function show($id)
    {
        $newest_blogs = $this->blog->newestBlog();
        $blog = $this->blog->getById($id);
        return view('pages.blog_details', compact('blog', 'newest_blogs'));
    }
}
