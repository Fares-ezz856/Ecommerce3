<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    use ApiResponse;
 public function create(CategoryRequest $categoryRequest){
   $validated= $categoryRequest->validated();
   $validated['slug']=Str::slug($categoryRequest->name);
   Category::create($validated);
   return $this->success('Category added Successfully',201);
 }
 public function edit($slug,Request $request){
    $category=Category::where('slug',$slug)->first();
   $validated= $request->validate([
        'name'=>'required',
    ]);
    if(!$category){
        return $this->error('category Not Found',200);
    }
    $validated['slug']=Str::slug($request->name);
    $category->update($validated);
    return $this->success('Updated Successfully');
 }
 public function delete($slug){
    $category=Category::where('slug',$slug)->first();
    if(!$category){
        return $this->error('category not found',200);
    }
        $category->delete();
        return $this->success('Deleted Successfully');
 }

 public function get($id){
    $category=Category::with('products')->find($id);
    if(!$category){
        return $this->error('There is no category',404);
    }
    return $this->success('This is category with product',200,$category);
 }
}
