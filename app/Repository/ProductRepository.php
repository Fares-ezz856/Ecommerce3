<?php
namespace App\Repository;

use App\Interface\ProductInterface;
use App\Models\Category;
use App\Models\Product;

class ProductRepository implements ProductInterface{
    public function create(array $data){
        Product::create($data);
    }
    public function getcategory($slug)
    {
         $category=Category::where('slug',$slug)->with('products')->first();
         return $category;
    }
}
