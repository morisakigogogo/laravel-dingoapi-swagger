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
    public function index()
    {
        //　取得全て
        // $categories = Category::all();
        // クエリsubカテゴリ 多层子分类
        // $categories = Category::select(['id', 'pid', 'name', 'level'])
        // ->where('pid', 0)->with('children.children:id,pid,name,level')->get();
        //helpersに定義している
        // return categoryTree();
        // return cache_category();
        return cache_category_all();
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
        //パラメータ検証
        $request->validate([
            'name' => 'required|max:16'
        ], [
            'name.required' => 'カテゴリは空にすることができません。'
        ]);

        // ID取得
        $pid = $request->input('pid');

        //計算level　pid 是0 就给他顶级 是1 
        // $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);
        $level = $pid == 0 ? 1 : (Category::find($pid)->level + 1);

        // カテゴリ３段に超えることができません。
        if($level > 3) {
            return $this->response->errorBadRequest('カテゴリ３段に超えることができません。');
        };
        $insertData = [
            'name' => $request->input('name'),
            'pid' => $pid,
            'level' => $level
            // 'level' => $pid == 0 ? 1 : (Category::find($pid)->level + 1)
        ];

        // $insertData = [
        //     'name' => $request->input('name'),
        //     'pid' => $pid,
        //     'level' => $level
        // ];


        Category::create($insertData);
        
        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
