<?php

namespace App\Http\Controllers;

use App\Models\StudentAssessment;
use Illuminate\Http\Request;

class StudentAssessmentController extends Controller
{
    // Menampilkan semua data student assessments
    public function index()
    {
        $studentAssessments = StudentAssessment::with(['user', 'assessment'])->get();

        return response()->json($studentAssessments, 200);
    }

    // Menampilkan detail student assessment
    public function show($id)
    {
        $studentAssessment = StudentAssessment::with(['user', 'assessment'])->find($id);

        if (!$studentAssessment) {
            return response()->json(['message' => 'Student Assessment not found'], 404);
        }

        return response()->json($studentAssessment, 200);
    }

    // Menambah student assessment baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assessment_id' => 'required|exists:assessments,id',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        // Membuat student assessment baru
        $studentAssessment = StudentAssessment::create($request->all());

        return response()->json([
            'message' => 'Student Assessment created successfully',
            'student_assessment' => $studentAssessment
        ], 201);
    }

    // Mengupdate student assessment
    public function update(Request $request, $id)
    {
        $studentAssessment = StudentAssessment::find($id);

        if (!$studentAssessment) {
            return response()->json(['message' => 'Student Assessment not found'], 404);
        }

        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assessment_id' => 'required|exists:assessments,id',
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        // Update student assessment
        $studentAssessment->update($request->all());

        return response()->json([
            'message' => 'Student Assessment updated successfully',
            'student_assessment' => $studentAssessment
        ], 200);
    }

    // Menghapus student assessment
    public function destroy($id)
    {
        $studentAssessment = StudentAssessment::find($id);

        if (!$studentAssessment) {
            return response()->json(['message' => 'Student Assessment not found'], 404);
        }

        $studentAssessment->delete();

        return response()->json(['message' => 'Student Assessment deleted successfully'], 200);
    }
}