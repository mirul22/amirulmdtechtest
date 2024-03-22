<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        try {
            $courses = Course::all()->map(function ($course) {
                $course->image = $course->image_url;
                $course->category_name = $course->category->name;
                return $course;
            });
            
            if ($courses->isEmpty()) {
                return response()->json(['message' => 'No courses found.'], 404);
            }

            return response()->json($courses);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->image = $course->image_url;

            return response()->json($course);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Course not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'category_id' => 'nullable|exists:categories,id',
                'status' => 'required|in:active,inactive',
                // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validatedData['image'] = $imagePath;
            }

            $course = Course::create($validatedData);
            $course->image = $course->image_url;

            return response()->json($course, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $course = Course::findOrFail($id);

            $validatedData = $request->validate([
                'title' => 'required|string',
                'content' => 'required|string',
                'category_id' => [
                    'nullable',
                    Rule::exists('categories', 'id')->whereNull('deleted_at'),
                ],
                'status' => 'required|in:active,inactive',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $course->update($validatedData);
            $course->image = $course->image_url;

            return response()->json($course, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $course->delete();
            return response()->json(['message' => 'Course deleted.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
