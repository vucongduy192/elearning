<?php

namespace App\Repositories;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Transformers\BlogTransformer;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use App\Traits\TransformPaginatorTrait;

class BlogRepository
{
    use BaseRepository, UploadTrait, TransformPaginatorTrait;
    protected $model, $blogTransformer;

    /**
     * Repository constructor.
     * @param Blog $blog
     * @param BlogTransformer $blogTransformer
     */
    public function __construct(Blog $blog, BlogTransformer $blogTransformer)
    {
        $this->blogTransformer = $blogTransformer;
        $this->model = $blog;
    }

    /**
     * Get list blog
     */
    public function pageWithRequest(Request $request, $number = 5, $searchColumn = 'title')
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $blogsPaginator = $this->model
            ->where($searchColumn, 'like', '%'.$request->get($searchColumn).'%')
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);

        return $this->buildTransformPaginator(
            $blogsPaginator,
            $this->blogTransformer
        );
    }

    /**
     * Store a new blog.
     *
     * @param  $input
     * @return
     */
    public function customStore(BlogRequest $request)
    {
        $input = $request->only(['title', 'summary', 'content']);
        $input['user_id'] = 1;
        $input['thumbnail'] = $this->uploadImage($request,
            $image_name = 'thumbnail', $folder = 'blog',
            $w = Blog::THUMBNAIL_WIDTH, $h = Blog::THUMBNAIL_HEIGHT);

        $this->store($input);
    }

    /**
     * Update a new blog.
     *
     * @param  $input
     * @return
     */
    public function customUpdate(BlogRequest $request, $id)
    {
        $input = $request->only(['title', 'summary', 'content']);
        $new_thumbnail = $this->uploadImage($request,
            $image_name = 'thumbnail', $folder = 'blog',
            $w = Blog::THUMBNAIL_WIDTH, $h = Blog::THUMBNAIL_HEIGHT);

        if ($new_thumbnail != '') {
            $input['thumbnail'] = $new_thumbnail;
            $this->removeFile($this->getById($id)->thumbnail);
        }

        $this->update($id, $input);
    }

    /**
     * Destroy a new category.
     *
     * @param  $input
     * @return
     */
    public function customDestroy($id)
    {
        $this->removeFile($this->getById($id)->thumbnail);
        $this->destroy($id);
    }

    /**
     * @param $number
     * @return mixed
     */
    public function filterBlog($number)
    {
        return $this->model->orderBy('created_at', 'desc')
            ->paginate($number);
    }

    public function newestBlog()
    {
        return $this->model->orderBy('created_at', 'desc')
            ->limit(2)->get();
    }
}
