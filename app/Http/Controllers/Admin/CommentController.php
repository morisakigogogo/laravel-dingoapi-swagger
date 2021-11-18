<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 評價列表
     */
    public function index()
    {
        //
        $comments = Comment::all();
        return $this->response->collection($comments);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 評價详情
     */
    public function show($id)
    {
        //
    }


    /**
     * 商家的回复
     */
    public function reply()
    {

    }
}
