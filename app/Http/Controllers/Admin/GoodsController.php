<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Category;
use App\Models\Good;
use App\Transformers\GoodTransformer;
use Dingo\Api\Auth\Auth;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 詳細
     */
    public function index(Request $request)
    {
        //
        // $goods = Good::all();
        $title = $request->query('title'); //タイトル検索機能
        $category_id = $request->query('category_id');
        $is_on = $request->query('is_on', false); //不传 给个默认 false
        $is_recommend = $request->query('is_recommend', false);//不传 给个默认 false

        
        $goods = Good::when($title, function($query) use ($title) {
            //当传了title
            $query->where('title', 'like', "%$title%");
        })->when($category_id, function($query) use ($category_id) {
            //当传了title
            $query->where('category_id', $category_id);
        })->when($is_on !== false, function($query) use ($is_on) {
            //当传了title
            $query->where('is_on', $is_on);
        })->when($is_recommend !== false, function($query) use ($is_recommend) {
            //当传了title
            $query->where('is_recommend', $is_recommend);
        })->paginate(2); //laravel 自带分页方法


        // $goods = Good::paginate(2); //laravel 自带分页方法

        return $this->response->paginator($goods, new GoodTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  
     * 商品追加
     */
    public function store(GoodsRequest $request)
    {
        // 对分类进行一些检查，只能使用3级分类，并且分类不能被禁用
        $category = Category::find($request->category_id);
        if (!$category) return $this->response->errorBadRequest('カテゴリ存在していません');
        if ($category->status == 0) return $this->response->errorBadRequest('カテゴリ禁用しています');
        if ($category->level != 3) return $this->response->errorBadRequest('只能向3级分类添加');


        //
        $user_id = 2;//auth('api')->id();//2;//auth('api')->id();
        // return [$user_id];
        // 2种方式  追加user_id到一起
        // $insertData = $request->all();
        // $insertData['user_id'] = $user_id;
        // Good::create($insertData);

        $request->offsetSet('user_id', $user_id);

        Good::create($request->all());
        return $this->response->created();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Good $good)
    {
        //
        return $this->response->item($good, new GoodTransformer());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodsRequest $request, Good $good)
    {
        //
        // 对分类进行一些检查，只能使用3级分类，并且分类不能被禁用
        $category = Category::find($request->category_id);
        if (!$category) return $this->response->errorBadRequest('カテゴリ存在していません');
        if ($category->status == 0) return $this->response->errorBadRequest('カテゴリ禁用しています');
        if ($category->level != 3) return $this->response->errorBadRequest('只能向3级分类添加');

        $good->update($request->all()); //调用update方法，就可以完成更新
        return $this->response->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function isOn(Good $good)
    {
        $good->is_on = $good->is_on == 0 ? 1 : 0;
        $good->save();
        return $this->response->noContent();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function isRecommend(Good $good)
    {
        $good->is_recommend = $good->is_recommend == 0 ? 1 : 0;
        $good->save();
        return $this->response->noContent();
    }
}
