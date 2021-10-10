<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //可批量添加
    protected $fillable = ['name', 'pid', 'level'];

    /** 
    * subカテゴリ
    */
    public function children()
    {
        return $this->hasMany(Category::class, 'pid', 'id');
    }
}
