<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'code' => 'nullable|string|unique:products,code',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'package_price' => 'nullable|numeric',
            'stock_quantity' => 'required|integer',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image',
            'is_visible' => 'boolean'
        ]);

        $product = new Product();
        $product->setTranslation('name', 'en', $request->name_en);
        $product->setTranslation('name', 'ar', $request->name_ar);
        $product->setTranslation('description', 'en', $request->description_en);
        $product->setTranslation('description', 'ar', $request->description_ar);
        
        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->package_price = $request->package_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->is_visible = $request->boolean('is_visible');

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'code' => 'nullable|string|unique:products,code,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'package_price' => 'nullable|numeric',
            'stock_quantity' => 'required|integer',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'image' => 'nullable|image',
            'is_visible' => 'boolean'
        ]);

        $product->setTranslation('name', 'en', $request->name_en);
        $product->setTranslation('name', 'ar', $request->name_ar);
        $product->setTranslation('description', 'en', $request->description_en);
        $product->setTranslation('description', 'ar', $request->description_ar);
        
        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->package_price = $request->package_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->is_visible = $request->boolean('is_visible');

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return back()->with('success', 'Product deleted successfully');
    }
}
