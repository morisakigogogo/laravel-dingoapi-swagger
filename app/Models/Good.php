<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    //可以批量赋值的字段
    protected $fillable = ['title', 'user_id', 'category_id', 'description','price','stock','cover','pics','is_on','is_recommend','detail'];


    /**
     * 强制转换的属性
     * 
     *  @var array
     */
    protected $casts = [
        'pics' => 'array',
    ];

    /**
     * 商品所属的分类
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    /**
    * 商品所属的用户
    */
   public function user()
   {
       return $this->belongsTo(User::class, 'user_id', 'id');
   }
}
