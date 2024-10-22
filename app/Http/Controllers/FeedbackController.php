<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    //
     // Menampilkan semua feedback
     public function index()
     {
         $feedbacks = Feedback::with('user')->get(); // Mendapatkan semua feedback dengan user terkait

         return response()->json($feedbacks, 200);
     }

     // Menampilkan detail feedback
     public function show($id)
     {
         $feedback = Feedback::with('user')->find($id); // Mendapatkan feedback berdasarkan id

         if (!$feedback) {
             return response()->json(['message' => 'Feedback not found'], 404);
         }

         return response()->json($feedback, 200);
     }

     // Menambah feedback baru
     public function store(Request $request)
     {
         // Validasi input
         $request->validate([
             'user_id' => 'required|exists:users,id',  // User harus ada di tabel users
             'feedback_text' => 'required|string',
             'feedback_date' => 'required|date'
         ]);

         // Membuat feedback baru
         $feedback = Feedback::create([
             'user_id' => $request->user_id,
             'feedback_text' => $request->feedback_text,
             'feedback_date' => $request->feedback_date
         ]);

         return response()->json([
             'message' => 'Feedback created successfully',
             'feedback' => $feedback
         ], 201);
     }

     // Mengupdate feedback
     public function update(Request $request, $id)
     {
         $feedback = Feedback::find($id);

         if (!$feedback) {
             return response()->json(['message' => 'Feedback not found'], 404);
         }

         // Validasi input
         $request->validate([
             'user_id' => 'required|exists:users,id',
             'feedback_text' => 'required|string',
             'feedback_date' => 'required|date'
         ]);

         // Update feedback
         $feedback->update([
             'user_id' => $request->user_id,
             'feedback_text' => $request->feedback_text,
             'feedback_date' => $request->feedback_date
         ]);

         return response()->json([
             'message' => 'Feedback updated successfully',
             'feedback' => $feedback
         ], 200);
     }

     // Menghapus feedback
     public function destroy($id)
     {
         $feedback = Feedback::find($id);

         if (!$feedback) {
             return response()->json(['message' => 'Feedback not found'], 404);
         }

         $feedback->delete();

         return response()->json(['message' => 'Feedback deleted successfully'], 200);
     }
}