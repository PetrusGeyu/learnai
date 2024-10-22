<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    //
      // Menampilkan semua lessons
      public function index()
      {
          $lessons = Lesson::with('course')->get(); // Mendapatkan semua lesson dengan course terkait

          return response()->json($lessons, 200);
      }

      // Menampilkan detail lesson
      public function show($id)
      {
          $lesson = Lesson::with('course')->find($id); // Mendapatkan lesson berdasarkan id, beserta course terkait

          if (!$lesson) {
              return response()->json(['message' => 'Lesson not found'], 404);
          }

          return response()->json($lesson, 200);
      }

      // Menambah lesson baru
      public function store(Request $request)
      {
          // Validasi input
          $request->validate([
              'course_id' => 'required|exists:courses,id',  // Course harus ada di tabel courses
              'lesson_title' => 'required|string|max:255',
              'lesson_content' => 'required|string',
          ]);

          // Membuat lesson baru
          $lesson = Lesson::create([
              'course_id' => $request->course_id,
              'lesson_title' => $request->lesson_title,
              'lesson_content' => $request->lesson_content,
          ]);

          return response()->json([
              'message' => 'Lesson created successfully',
              'lesson' => $lesson
          ], 201);
      }

      // Mengupdate lesson
      public function update(Request $request, $id)
      {
          $lesson = Lesson::find($id);

          if (!$lesson) {
              return response()->json(['message' => 'Lesson not found'], 404);
          }

          // Validasi input
          $request->validate([
              'course_id' => 'required|exists:courses,id',
              'lesson_title' => 'required|string|max:255',
              'lesson_content' => 'required|string',
          ]);

          // Update lesson
          $lesson->update([
              'course_id' => $request->course_id,
              'lesson_title' => $request->lesson_title,
              'lesson_content' => $request->lesson_content,
          ]);

          return response()->json([
              'message' => 'Lesson updated successfully',
              'lesson' => $lesson
          ], 200);
      }

      // Menghapus lesson
      public function destroy($id)
      {
          $lesson = Lesson::find($id);

          if (!$lesson) {
              return response()->json(['message' => 'Lesson not found'], 404);
          }

          $lesson->delete();

          return response()->json(['message' => 'Lesson deleted successfully'], 200);
      }
}