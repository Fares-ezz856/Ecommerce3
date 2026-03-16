<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;
    public function index(){
        $carts=Cart::where('user_id',auth('user')->id())->with('product')->get();
        if($carts->isEmpty()){
            return $this->success('Your Cart Is Empty',200);
        }
        return $this->success('This is Your cart',200,CartResource::collection($carts));
    }
    public function add(Request $request,$id){
         $request->validate([
            'quantity'=>'numeric|required',
        ]);
        $cartitem=Cart::where('user_id',auth('user')->id())->where('product_id',$id)->first();
        if($cartitem){
            $cartitem->increment('quantity',$request->quantity);
        }
        else{
             Cart::create([
            'user_id'=>auth('user')->id(),
            'product_id'=>$id,
            'quantity'=>$request->quantity
        ]);


        }
           $product=Product::where('id',$id)->first();
        $product->decrement('stock_quantity',$request->quantity);
        return $this->success('Added To Cart Successfully');

    }
}
