<?php
namespace App\Traits;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

trait TransformPaginatorTrait {
    /**
     * 
     */
    public function buildTransformPaginator($entityPaginator, $entityTransform)
    {
        $fractal = new Manager();
        $paginator = new IlluminatePaginatorAdapter($entityPaginator);
        $paginator = $paginator->getPaginator()->toArray();
        unset($paginator['data']);

        $entity = new Collection($entityPaginator->items(), $entityTransform);
        $transform = $fractal->createData($entity)->toArray();;
        $transform_paginator = array_merge($transform, $paginator);
        
        return $transform_paginator;
    }
}
