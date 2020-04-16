<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\RuleRequest;
use App\Repositories\RuleRepository;
use App\Http\Controllers\Controller;
use App\Models\Category;

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
        $columns = Category::pluck("id")->toArray();  // array(["id" =>"name"])   
        $matrix_csv = "category_id,".implode(",", $columns)."\n";

        foreach ($columns as $row_id => $category_id_i) {
            $row = array();
            foreach ($columns as $category_id_j) {
                $rule = $this->entity->getRule($category_id_i, $category_id_j)
                            ->first();

                $row[$category_id_j] = $rule ? $rule->weight : 0;
                if ($category_id_i == $category_id_j) {
                    $row[$category_id_j] = 1;
                }
            }
            $matrix_csv .= strval($category_id_i).",".implode(",", $row)."\n";
        }

        $fileName = "category_matrix.csv";
        $filePath = public_path("recommend/".$fileName);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $fp = fopen($filePath, "w+");
        fwrite($fp, $matrix_csv);
        fclose($fp);

        return $this->response();
    }
}
