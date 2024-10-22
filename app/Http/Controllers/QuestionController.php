<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
      // Menampilkan semua questions
      public function index()
      {
          $questions = Question::with('assessment')->get(); // Mendapatkan semua question dengan assessment terkait

          return response()->json($questions, 200);
      }

      // Menampilkan detail question
      public function show($id)
      {
          $question = Question::with('assessment')->find($id); // Mendapatkan question berdasarkan id

          if (!$question) {
              return response()->json(['message' => 'Question not found'], 404);
          }

          return response()->json($question, 200);
      }

      // Menambah question baru
      public function store(Request $request)
      {
          // Validasi input
          $request->validate([
              'assessment_id' => 'required|exists:assessments,id',  // Assessment harus ada di tabel assessments
              'question_text' => 'required|string',
              'question_type' => 'required|in:multiple choice,essay',  // Validasi tipe pertanyaan
              'correct_answer' => 'required|string'
          ]);

          // Membuat question baru
          $question = Question::create([
              'assessment_id' => $request->assessment_id,
              'question_text' => $request->question_text,
              'question_type' => $request->question_type,
              'correct_answer' => $request->correct_answer
          ]);

          return response()->json([
              'message' => 'Question created successfully',
              'question' => $question
          ], 201);
      }

      // Mengupdate question
      public function update(Request $request, $id)
      {
          $question = Question::find($id);

          if (!$question) {
              return response()->json(['message' => 'Question not found'], 404);
          }

          // Validasi input
          $request->validate([
              'assessment_id' => 'required|exists:assessments,id',
              'question_text' => 'required|string',
              'question_type' => 'required|in:multiple choice,essay',
              'correct_answer' => 'required|string'
          ]);

          // Update question
          $question->update([
              'assessment_id' => $request->assessment_id,
              'question_text' => $request->question_text,
              'question_type' => $request->question_type,
              'correct_answer' => $request->correct_answer
          ]);

          return response()->json([
              'message' => 'Question updated successfully',
              'question' => $question
          ], 200);
      }

      // Menghapus question
      public function destroy($id)
      {
          $question = Question::find($id);

          if (!$question) {
              return response()->json(['message' => 'Question not found'], 404);
          }

          $question->delete();

          return response()->json(['message' => 'Question deleted successfully'], 200);
      }
}