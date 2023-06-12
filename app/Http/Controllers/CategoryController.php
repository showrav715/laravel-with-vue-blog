<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required | unique:categories',
        ]);

        $name = $request->input('name');
        $category = new Category();
        $category->name = $name;
        $category->save();
        return response()->json([
            'message' => 'Category created',
            'category' => $category,
        ], 201
        );
    }

    public function index()
    {
        return Category::orderby('id','desc')->get();
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required | unique:categories,name,'.$category->id,
        ]);

        $name = $request->input('name');
        $category->name = $name;

        $category->save();
        return response()->json([
            'message' => 'Category updated',
            'category' => $category,
        ], 200
        );
    }

    public function destroy(Category $category)
    {
         $category->delete();
        return response()->json([
            'message' => 'Category deleted',
        ], 200
        );
    }
}