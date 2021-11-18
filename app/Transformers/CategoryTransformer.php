<?php

namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{

  public function transform(Category $category)
  {
    return [ //分类数据用
      'id' => $category->id,
      'name' => $category->name
    ];
  }
}