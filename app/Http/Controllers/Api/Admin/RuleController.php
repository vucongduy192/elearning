<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RuleRequest;
use App\Repositories\RuleRepository;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;

class RuleController extends Controller
{
    protected $entity;
    
    public function __construct(RuleRepository $ruleRepository)
    {
        $this->entity = $ruleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response($this->entity->pageWithRequest($request));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RuleRequest $request)
    {
        $rules = $this->entity->getRule($request->get("cat_id1"), $request->get("cat_id2"));
        if ($rules->first()) {
            return $this->response(
                ["message" => "The rule is existed"], $status=400
            );
        }

        $this->entity->store($request->all());
        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->entity->getById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RuleRequest $request, $id)
    {
        $rules = $this->entity->getRule(
            $request->get("cat_id1"), 
            $request->get("cat_id2")
        );
        // dd($rules->count());
        if ($rules->first() && $rules->first()->id != $id) {
            return $this->response(
                ["message" => "The rule is existed"], $status=400
            );
        }
        $this->entity->update($id, $request->all());
        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->entity->destroy($id);
        return $this->response();
    }

    public function dumpCSV()
    {
        # --------------------------------------------------- #
        # Export category matrix from SQL rule
        $categories = Category::pluck("name", "id")->toArray();  // array(["id" =>"name"])
        $category_matrix_csv = "category,".implode(",", array_values($categories))."\n";

        foreach (array_keys($categories) as $cat_i) {
            $row = array();
            foreach (array_keys($categories) as $cat_j) {
                $rule = $this->entity->getRule($cat_i, $cat_j)->first();

                $row[$cat_j] = $rule ? $rule->weight : 0;
                if ($cat_i == $cat_j) {
                    $row[$cat_j] = 1;
                }
            }
            $category_matrix_csv .= $categories[$cat_i].",".implode(",", $row)."\n";
        }

        $filePath = public_path("recommend/category_matrix.csv");
        $this->saveCSV($filePath, $category_matrix_csv);

        # --------------------------------------------------- #
        # Export course matrix from category matrix values
        $courses = Course::pluck("name", "id")->toArray();  // array(["id" =>"name"])   
        $course_matrix_csv = "course,".implode(",", array_values($courses))."\n";
        foreach (array_keys($courses) as $c_i) {
            $row = array();
            foreach (array_keys($courses) as $c_j) {
                $row[$c_j] = $this->entity->getWeight($c_i, $c_j);
            }
            $course_matrix_csv .= $courses[$c_i].",".implode(",", $row)."\n";
        }

        $filePath = public_path("recommend/similarC_matrix.csv");
        $this->saveCSV($filePath, $course_matrix_csv);

        return $this->response();
    }

    public function saveCSV($filePath, $csv)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $fp = fopen($filePath, "w+");
        fwrite($fp, $csv);
        fclose($fp);
    }
}
