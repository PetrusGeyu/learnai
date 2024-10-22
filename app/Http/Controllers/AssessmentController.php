<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    //
    public function index()
    {
        $assessments = Assessment::with('course')->get(); // Mendapatkan semua assessment dengan course terkait

        return response()->json($assessments, 200);
    }

    // Menampilkan detail assessment
    public function show($id)
    {
        $assessment = Assessment::with('course')->find($id); // Mendapatkan assessment berdasarkan id, beserta course terkait

        if (!$assessment) {
            return response()->json(['message' => 'Assessment not found'], 404);
        }

        return response()->json($assessment, 200);
    }

    // Menambah assessment baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:courses,id',  // Course harus ada di tabel courses
            'assessment_title' => 'required|string|max:255',
            'assessment_type' => 'required|in:initial,final,evaluation',  // Hanya boleh salah satu dari tiga tipe
            'assessment_date' => 'required|date',
            'difficulty_level' => 'required|integer|min:1|max:5'  // Tingkat kesulitan 1 sampai 5
        ]);

        // Membuat assessment baru
        $assessment = Assessment::create([
            'course_id' => $request->course_id,
            'assessment_title' => $request->assessment_title,
            'assessment_type' => $request->assessment_type,
            'assessment_date' => $request->assessment_date,
            'difficulty_level' => $request->difficulty_level,
        ]);

        return response()->json([
            'message' => 'Assessment created successfully',
            'assessment' => $assessment
        ], 201);
    }

    // Mengupdate assessment
    public function update(Request $request, $id)
    {
        $assessment = Assessment::find($id);

        if (!$assessment) {
            return response()->json(['message' => 'Assessment not found'], 404);
        }

        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'assessment_title' => 'required|string|max:255',
            'assessment_type' => 'required|in:initial,final,evaluation',
            'assessment_date' => 'required|date',
            'difficulty_level' => 'required|integer|min:1|max:5'
        ]);

        // Update assessment
        $assessment->update([
            'course_id' => $request->course_id,
            'assessment_title' => $request->assessment_title,
            'assessment_type' => $request->assessment_type,
            'assessment_date' => $request->assessment_date,
            'difficulty_level' => $request->difficulty_level,
        ]);

        return response()->json([
            'message' => 'Assessment updated successfully',
            'assessment' => $assessment
        ], 200);
    }

    // Menghapus assessment
    public function destroy($id)
    {
        $assessment = Assessment::find($id);

        if (!$assessment) {
            return response()->json(['message' => 'Assessment not found'], 404);
        }

        $assessment->delete();

        return response()->json(['message' => 'Assessment deleted successfully'], 200);
    }
}