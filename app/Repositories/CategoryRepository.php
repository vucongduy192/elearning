<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;
use App\Traits\UploadTrait;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;

class CategoryRepository {
    use BaseRepository, UploadTrait;
    protected $model;
    /**
     * Constructor
     *
     * @param Category $category
     */
    public function __construct(Category $category, CategoryTransformer $categoryTransformer)
    {
        $this->categoryTransformer = $categoryTransformer;
        $this->model = $category;
    }

    /**
     * Get list category
     */
    public function pageWithRequest($request, $number = 5, $sort = 'desc', $sortColumn = 'created_at')
    {
        $categories = $this->model->orderBy('created_at', 'desc')->paginate($number);
        if (isset($categories['data']))
            $categories['data'] = $this->categoryTransformer->transform($categories['data'])->toArray();

        return $categories;
    }

    /**
     * Store a new category.
     *
     * @param  $input
     * @return 
     */
    public function customStore(CategoryRequest $request)
    {
        $input = $request->only(['name', 'overview']);
        $input['thumbnail'] = $this->uploadImage($request, $image_name="thumbnail");
        $this->store($input);
    }

    /**
     * Update a new category.
     *
     * @param  $input
     * @return 
     */
    public function customUpdate(CategoryRequest $request, $id)
    {
        $input = $request->only(['name', 'overview']);
        $new_thumbnail = $this->uploadImage($request, $image_name="thumbnail");
        if ($new_thumbnail != '')
            $input['thumbnail'] = $new_thumbnail;
            $this->removeImage($this->getById($id)->thumbnail);

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
        $this->removeImage($this->getById($id)->thumbnail);
        $this->destroy($id);
    }
}