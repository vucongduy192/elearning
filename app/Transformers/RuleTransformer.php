<?php

namespace App\Transformers;

use App\Models\Rule;
use League\Fractal\TransformerAbstract;

class RuleTransformer extends TransformerAbstract
{
    public function transform(Rule $rule)
    {
        return [
            'id' => $rule->id,
            'cat_id1' => $rule->cat_id1,
            'cat_id2' => $rule->cat_id2,
            'category1' => $rule->category1->name,
            'category2' => $rule->category2->name,
            'weight' => $rule->weight,
        ];
    }
}