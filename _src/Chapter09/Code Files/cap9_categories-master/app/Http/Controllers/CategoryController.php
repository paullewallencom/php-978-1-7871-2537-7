<?php

namespace App\Http\Controllers;

use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request) {
        $category = new Category();

        $category->fill(['value' => $request->input('value')]);

        $category->save();

        return response()->json([]);
    }

    public function updateCategory(Request $request, $id) {
        $category = Category::find($id);

        $category->value = $request->input('value');

        $category->save();

        return response()->json([]);
    }

    public function deleteCategory(Request $request, $id) {
        $category = Category::find($id);
        $category->delete();

        return response()->json([]);
    }

    public function getCategories(Request $request) {
        $categories = Category::get();

        return $categories;
    }

    public function getCategory(Request $request, $id) {
        $category = Category::find($id);

        return $category;
    }

}