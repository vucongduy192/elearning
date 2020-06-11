<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Course;
use App\Http\Controllers\Controller;


class MatrixController extends Controller
{
    /**
     * Get combine Coefficient
     */
    public function getConfig()
    {
        return $this->response($data=Config::first(), $status=200);
    }

    /**
     * Set up combine Coefficient, merge rule_similar & enroll_similar 
     */
    public function updateCoefficient(Request $request)
    {
        $config = Config::first();
        if (empty($config)) {
            $config = new Config();
        }
        $config->c = $request->c;
        $config->save();

        $this->combineMatrix($config->c);
    }

    /**
     * Save similar item matrix to CSV
     */
    public function combineMatrix($c)
    {
        $courses = Course::pluck("name", "id")->toArray();  // array(["id" =>"name"])
        $similar_matrix_csv = "course,".implode(",", array_values($courses))."\n";

        $simC_csv_path = public_path("recommend/similarC_matrix.csv");
        $simE_csv_path = public_path("recommend/similarE_matrix.csv");

        $fileC = fopen($simC_csv_path, 'r');
        $fileE = fopen($simE_csv_path, 'r');

        $rowC = fgetcsv($fileC, 0, ',');
        $rowE = fgetcsv($fileE, 0, ',');

        while (($rowC = fgetcsv($fileC, 0, ',')) !== false && ($rowE = fgetcsv($fileE, 0, ',')) !== false) {
            $row = array();
            foreach (range(1, count($courses)) as $key) {
                $row[$key] = $c * $rowC[$key] + (1 - $c) * $rowE[$key];
            }
            $similar_matrix_csv .= $rowC[0].",".implode(",", $row)."\n";
        }

        $filePath = public_path("recommend/similar_matrix.csv");
        $this->saveCSV($filePath, $similar_matrix_csv);
    }

    /**
     * Save csv to /public/recommend
     */
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
