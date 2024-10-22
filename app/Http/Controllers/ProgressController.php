<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    // Menampilkan semua progress
    public function index()
    {
        $progresses = Progress::with(['user', 'course'])->get();

        return response()->json($progresses, 200);
    }

    // Menampilkan detail progress
    public function show($id)
    {
        $progress = Progress::with(['user', 'course'])->find($id);

        if (!$progress) {
            return response()->json(['message' => 'Progress not found'], 404);
        }

        return response()->json($progress, 200);
    }

    // Menambah progress baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'completion_percentage' => 'required|integer|min:0|max:100'
        ]);

        // Membuat progress baru
        $progress = Progress::create($request->all());

        return response()->json([
            'message' => 'Progress created successfully',
            'progress' => $progress
        ], 201);
    }

    // Mengupdate progress
    public function update(Request $request, $id)
    {
        $progress = Progress::find($id);

        if (!$progress) {
            return response()->json(['message' => 'Progress not found'], 404);
        }

        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'completion_percentage' => 'required|integer|min:0|max:100'
        ]);

        // Update progress
        $progress->update($request->all());

        return response()->json([
            'message' => 'Progress updated successfully',
            'progress' => $progress
        ], 200);
    }

    // Menghapus progress
    public function destroy($id)
    {
        $progress = Progress::find($id);

        if (!$progress) {
            return response()->json(['message' => 'Progress not found'], 404);
        }

        $progress->delete();

        return response()->json(['message' => 'Progress deleted successfully'], 200);
    }
}