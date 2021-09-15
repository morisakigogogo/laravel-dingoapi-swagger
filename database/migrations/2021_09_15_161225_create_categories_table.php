<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('カテゴリ名')
            $table->integer('pid')->default(0)->comment('parents')
            $table->tinyInteger('status')->default(1)->comment('ステータス：0オフ　１オン')
            $table->tinyInteger('level')->default(1)->comment('分類レベル 1 2 3')
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
        Schema::dropIfExists('categories');
    }
}
