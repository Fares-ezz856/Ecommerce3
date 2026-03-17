<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'package_price', 'code',
        'stock_quantity', 'image', 'category_id', 'is_visible'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }
}
