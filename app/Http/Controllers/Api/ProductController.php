<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{
    private $repo;
    public function __construct(ProductRepository $productRepository)
    {
        $this->repo=$productRepository;
    }
    use ApiResponse;
        public function getallproducts(){
        $products=Product::with('category')->paginate(10);
        foreach($products as $product){
            $product['image']=asset('storage/'.$product->image);
        }
        if($products->isEmpty()){
            return $this->success("There's No Products until Now");
        }
        return $this->success('This is All Products',200,ProductResource::collection($products));
    }
    public function getcategory($slug){
        $category=$this->repo->getcategory($slug);
        if(!$category){
            return $this->error('This Category Not Found',200);
        }
        return $this->success('This is category with products',200,new CategoryResource($category));
    }
    public function showproduct($id){
        $product=Product::find($id);
        if(!$product){
            return $this->error('Not Found This Product',200);
        }
        return $this->success('This is product',200,new ProductResource($product));
    }

    public function create(ProductRequest $productRequest){
        $validated=$productRequest->validated();
        if($productRequest->hasFile('image')){
            $image=$productRequest->image;
            $filename=$productRequest->name.'-'.time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $validated['image']=$path;
        }
       $this->repo->create($validated);
        return $this->success('Product Added Successfully',201);
    }
    public function update(Request $request,Product $product){
        $validated=$request->validate([
               'name'=>'sometimes',
            'description'=>'sometimes',
            'price'=>'sometimes|numeric',
            'stock_quantity'=>'sometimes|integer',
            'image'=>'sometimes|image',
            'category_id'=>'sometimes|exists:categories,id'
        ]);
        if($request->hasFile('image')){
           if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }
         $image=$$request->image;
        $filename=$request->name.'-'.time().'.'.$image->getClientOriginalExtension();
            $path = $image->storeAs('products', $filename, 'public');
            $validated['image']=$path;
    }
    $product->update($validated);
return $this->success('Product Updated Successfully', 200);
}
public function delete(Product $product){
    if(!$product){
        return $this->error('Product Not Found',200);
    }
    $product->delete();
    return $this->success('Product Deleted Successfully',200);
}
public function search(Request $request){
    $query=$request->input('search');
    $products=Product::with('category')->where('name','LIKE',"%{$query}%")->paginate(10);
    if($products->isEmpty()){
        return $this->error('There is no products',404);
    }
    return $this->success('This is All Products',200,ProductResource::collection($products));
}
}
