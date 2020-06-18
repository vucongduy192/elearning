<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;

class ConfigController extends Controller
{
    protected $entity, $sub_entity;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->entity = $courseRepository;
    }
    
    public function getNameConvert()
    {
        return $this->response($this->entity->getNameConvert());
    }
}
