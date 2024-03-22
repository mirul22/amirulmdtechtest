<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            $data = ['categories' => $categories];
            
            return response()->json([
                'status' => true, 
                'message' => 'Categories retrieved successfully.', 
                'items' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => $validator->errors()
                ], 400);
            }

            $category = Category::create($validator->validated());

            return response()->json([
                'status' => true, 
                'message' => 'Category created successfully.', 
                'items' => $category
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json([
                'status' => true, 
                'message' => 'Category retrieved successfully.', 
                'items' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => 'Category not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => $validator->errors()
                ], 400);
            }

            $category->update($validator->validated());

            return response()->json([
                'status' => true, 
                'message' => 'Category updated successfully.', 
                'items' => $category
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'status' => true, 
                'message' => 'Category deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
