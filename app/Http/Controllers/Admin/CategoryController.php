<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //カテゴリリスト
    public function index(Request $request)
    {
        //　取得全て
        // $categories = Category::all();
        // クエリsubカテゴリ 多层子分类
        // $categories = Category::select(['id', 'pid', 'name', 'level'])
        // ->where('pid', 0)->with('children.children:id,pid,name,level')->get();
        //helpersに定義している
        // return categoryTree();
        // return cache_category();
        $type = $request->input('type');
        if ($type == 'all') {
            return cache_category_all();
        } else {
            return cache_category();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * カテゴリ追加 最大３段分類
     */
    public function store(Request $request)
    {
        $insertData = $this->checkInput($request);
        if(!is_array($insertData)) return $insertData;

        Category::create($insertData);

        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * カテゴリ詳細
     * http://shopapi.test/api/admin/category/{categoryid}
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestx
     * @param  int  $id
     * カテゴリ更新
     */
    public function update(Request $request, Category $category)
    {
        $updateData = $this->checkInput($request);
        if(!is_array($updateData)) return $updateData;

        $category->update($updateData);

        return $this->response->noContent();
    }
    protected function checkInput($request)
    {
        // パラメータ検証
        $request->validate([
            'name' => 'required|max:16'
        ], [
            'name.required' => 'カテゴリは空にすることができません。'
        ]); //这里会返回响应的实例

        // ID取得
        $pid = $request->input('pid');

        //計算level　pid 是0 就给他顶级 是1 
        // $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);

        // カテゴリ３段に超えることができません。
        if($level > 3) {
            return $this->response->errorBadRequest('カテゴリ３段に超えることができません。');
        }
        return [
            'name' => $request->input('name'),
            'pid' => $pid,
            'level' => $level
        ];

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 状態OFF・ON
     * shopapi.test/api/admin/category/5/status
     */
    public function status(Category $category) //依赖注入
    {
        $category->status = $category->status == 1 ? 0 : 1;
        $category->save();

        return $this->response->noContent();
    }
}
