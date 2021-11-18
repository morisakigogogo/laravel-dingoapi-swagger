<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('作成者');
            $table->integer('category_id')->comment('カテゴリ');
            $table->string('title')->comment('商品タイトル');
            $table->string('description')->comment('デスクリプション');
            $table->integer('price')->comment('価格');
            $table->integer('stock')->comment('在庫');
            $table->string('cover')->comment('バナー');
            $table->json('pics')->comment('画像');
            $table->tinyInteger('is_on')->default(0)->comment('出品:0,1');
            $table->tinyInteger('is_recommend')->default(0)->comment('おすすめ:0,1');
            $table->text('detail')->comment('商品詳細');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
