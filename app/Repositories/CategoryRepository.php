<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Traits\UploadTrait;
use App\Traits\TransformPaginatorTrait;
use App\Transformers\CategoryTransformer;
use App\Http\Requests\CategoryRequest;

class CategoryRepository
{
    use BaseRepository, UploadTrait, TransformPaginatorTrait;
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
    public function pageWithRequest(Request $request, $number = 5, $searchColumn = 'name')
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $categoriesPaginator = $this->model
            ->where($searchColumn, 'like', '%'.$request->get($searchColumn).'%')
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);
        
        return $this->buildTransformPaginator(
            $categoriesPaginator, 
            $this->categoryTransformer
        );
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
        $input['thumbnail'] = $this->uploadImage($request, $image_name = "thumbnail");
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
        $new_thumbnail = $this->uploadImage($request, $image_name = "thumbnail");
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
}
