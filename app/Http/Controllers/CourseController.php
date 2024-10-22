<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('lessons')->get(); // Mendapatkan semua course dengan lesson terkait

        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
         // Validasi input
         $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
        ]);

        // Membuat course baru
        $course = Course::create([
            'course_name' => $request->course_name,
            'course_description' => $request->course_description,
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'course' => $course
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

        $course = Course::with('lessons')->find($id); // Mendapatkan course berdasarkan id, beserta lessons

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        // Validasi input
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_description' => 'required|string',
        ]);

        // Update course
        $course->update([
            'course_name' => $request->course_name,
            'course_description' => $request->course_description
        ]);

        return response()->json([
            'message' => 'Course updated successfully',
            'course' => $course
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();

        return response()->json(['message' => 'Course deleted successfully'], 200);
    }
}
