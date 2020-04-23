<?php

namespace App\Repositories;

use App\Models\Rule;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Models\Course;
use App\Transformers\RuleTransformer;
use App\Traits\TransformPaginatorTrait;

class RuleRepository {
    use BaseRepository, TransformPaginatorTrait;
    protected $model;

    /**
     * Constructor
     *
     * @param Category $category
     */
    public function __construct(Rule $rule, RuleTransformer $ruleTransformer, CourseRepository $courseRepository)
    {
        $this->ruleTransformer = $ruleTransformer;
        $this->model = $rule;
    }

    /**
     * Get list category
     */
    public function pageWithRequest(Request $request, $number = 5)
    {
        $sortType = $request->get('sortType') ? $request->get('sortType') : 'desc';
        $sortColumn = $request->get('sortColumn') ? $request->get('sortColumn') : 'id';

        $rulesPaginator = $this->model
            ->orderBy($sortColumn, $sortType)
            ->paginate($number);
        
        return $this->buildTransformPaginator(
            $rulesPaginator, 
            $this->ruleTransformer
        );
    }

    /**
     * Find rule if existed
     */
    public function getRule($cat_id1, $cat_id2)
    {
        $rule = $this->model->where([
            ['cat_id1', $cat_id1],
            ['cat_id2', $cat_id2],
        ])->orWhere([
            ['cat_id1', $cat_id2],
            ['cat_id2', $cat_id1],
        ])->get();
        
        return $rule;
    }

    /**
     * Find rule if existed
     */
    public function getWeight($c_i, $c_j)
    {
        $cat_id1 = Course::where('id', $c_i)->first()->courses_category_id;
        $cat_id2 = Course::where('id', $c_j)->first()->courses_category_id;

        $rule = $this->getRule($cat_id1, $cat_id2)->first();
        $weight = $rule ? $rule->weight : 0;
        if ($cat_id1 == $cat_id2) {
            $weight = 1;
        }

        return $weight;
    }
}