<?php

namespace App\Transformers;

use App\Models\Module;
use League\Fractal\TransformerAbstract;

class ModuleTransformer extends TransformerAbstract
{
    public function transform(Module $module)
    {
        return [
            'id' => $module->id,
            'name' => $module->name,
            'overview' => $module->overview,
            'lectures' => $module->lectures,
            'course' => $module->course,
        ];
    }
}
