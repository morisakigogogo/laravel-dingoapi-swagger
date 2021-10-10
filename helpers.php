<?php

use App\Models\Category;

/**
 * all category*/ 
if (!function_exists('categoryTree')) {
  function categoryTree($status = false)
  {
    dd('categoryTree');
    $categories = Category::select(['id', 'pid', 'name', 'level', 'status'])//开始查找时分类 1级分类
    ->when($status !== false, function($query) use ($status) {
      $query->where('status', $status);
    })
    ->where('pid', 0)
    ->with([
        // 'children:id,pid,name,level,status',//2级分类
        'children' => function($query) use ($status) {
          $query->select(['id', 'pid', 'name', 'level', 'status'])
          ->when($status !== false, function ($query) use ($status) {
            $query->where('status', $status);
          });
        },
        'children.children' => function ($query) use ($status) {
            $query->when($status !== false, function($query) use ($status) {
              $query->where('status', $status);
            });
          }
        ]) 
    ->get();

    return $categories;
  }
}

/**
 * 緩存沒被禁用的分類*/ 
if (!function_exists('cache_category')) {
  function cache_category()
  {
    return cache()->rememberForever('cache_category', function () {
      //传个1 只拿到没被禁用的
      return categoryTree(1);
    });
  }
}
/**
 * 緩存所有的分類*/ 
if (!function_exists('cache_category_all')) {
  function cache_category_all()
  {
    return cache()->rememberForever('cache_category_all', function () {
      //獲取所有的緩存 不传
      return categoryTree();
    });
  }
}
/**
 * 清空分类缓存*/ 
if (!function_exists('forget_cache_category')) {
  function forget_cache_category()
  {
    cache()->forget('cache_category');
    cache()->forget('cache_category_all');
  }
}