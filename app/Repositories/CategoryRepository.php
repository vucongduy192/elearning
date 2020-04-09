<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepository {
    use BaseRepository;

    protected $model;

    /**
     * Constructor
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

}