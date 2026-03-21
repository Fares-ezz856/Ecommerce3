<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:categories,name->en',
            // 'name_ar' => 'required|string|max:255|unique:categories,name->ar',

        ]);
    $tr=new GoogleTranslate();
    try{
        $name_ar=$tr->setSource('en')->setTarget('ar')->translate($request->name_en);
    }
    catch(\Exception $e){
        $name_ar=$request->name_en;
    }
        $category = new Category();
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $name_ar);

        // Slug can be based on English name for simplicity, or also translatable if preferred.
        // The migration changed it to JSON, so let's make it translatable.
        $category->setTranslation('slug', 'en', Str::slug($request->name_en));
        $category->setTranslation('slug', 'ar', Str::slug($name_ar)); // Or some other logic

        $category->save();
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_en' => 'required|string|max:255|unique:categories,name->en,' . $category->id,
            'name_ar' => 'required|string|max:255|unique:categories,name->ar,' . $category->id,
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string'
        ]);

        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('name', 'ar', $request->name_ar);

        $category->setTranslation('description', 'en', $request->description_en);
        $category->setTranslation('description', 'ar', $request->description_ar);

        $category->setTranslation('slug', 'en', Str::slug($request->name_en));
        $category->setTranslation('slug', 'ar', Str::slug($request->name_en));

        $category->save();
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }
}
