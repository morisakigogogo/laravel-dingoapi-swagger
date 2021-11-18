<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Good;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends TransformerAbstract
{
  protected $availableIncludes = ['category', 'user']; //分类数据用

  public function transform(Good $good)
  {
    return [
      'id' => $good->id,
      'title' => $good->title,
      'category_id' => $good->category_id,
      // 'category_name' => Category::find($good->category_id)->name, //通过分类ID查询分类名称，然后返回
      'description' => $good->description,
      'price' => $good->price,
      'stock' => $good->stock,
      'cover' => $good->cover,
      'pics' => $good->pics,
      'detail' => $good->detail,
      'is_on' => $good->is_on,
      'is_recommend' => $good->is_recommend,
      'created_at' => $good->created_at,
      'updated_at' => $good->updated_at
    ];
  }

  /**
   * 额外的分类数据
   */
  public function includeCategory(Good $good)
  {
    //分类数据用 $this->item 就是在当前返回到transformer里面加上一个item，
    return $this->item($good->category, new CategoryTransformer());
  }
  /**
   * 额外的用户数据
   */
  public function includeUser(Good $good)
  {
    //分类数据用 $this->item 就是在当前返回到transformer里面加上一个item，
    return $this->item($good->user, new UserTransformer());
  }
}
/** 额外的分类数据
 * shopapi.test/api/admin/goods?include=category
 * 加上 include 就会返回给front的数据
 * "category": {
 *               "id": 8,
*              "name": "富士通"
*          }
 * 
 */
// {
//   "data": [
//       {
//           "id": 1,
//           "title": "PC１です。",
//           "category_id": 8,
//           "description": "これはPCです。",
//           "price": 158000,
//           "stock": 999,
//           "cover": "/imgs/img1.png",
//           "pics": [
//               "a.png",
//               "b.png"
//           ],
//           "detail": "これはPCです。これはPCです。これはPCです。これはPCです。これはPCです。",
//           "is_on": 0,
//           "is_recommend": 0,
//           "created_at": "2021-10-29T08:11:39.000000Z",
//           "updated_at": "2021-10-29T08:11:39.000000Z",
//           "category": {
//               "id": 8,
//               "name": "富士通"
//           }
//       },
//       {
//           "id": 2,
//           "title": "PC2です。",
//           "category_id": 8,
//           "description": "これはPCです。",
//           "price": 158000,
//           "stock": 999,
//           "cover": "/imgs/img2.png",
//           "pics": [
//               "c.png",
//               "d.png"
//           ],
//           "detail": "これはPC2です。これはPC2です。これはPC2です。これはPC2です。これはPC2です。",
//           "is_on": 0,
//           "is_recommend": 0,
//           "created_at": "2021-10-29T08:12:40.000000Z",
//           "updated_at": "2021-10-29T08:12:40.000000Z",
//           "category": {
//               "id": 8,
//               "name": "富士通"
//           }
//       }
//   ],
//   "meta": {
//       "pagination": {
//           "total": 5,
//           "count": 2,
//           "per_page": 2,
//           "current_page": 1,
//           "total_pages": 3,
//           "links": {
//               "previous": null,
//               "next": "http://shopapi.test/api/admin/goods?page=2"
//           }
//       }
//   }
// }