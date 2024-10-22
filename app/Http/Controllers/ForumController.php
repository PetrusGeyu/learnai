<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    // Menampilkan semua forum
    public function index()
    {
        $forums = Forum::with('course')->get();

        return response()->json($forums, 200);
    }

    // Menampilkan detail forum
    public function show($id)
    {
        $forum = Forum::with('course')->find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        return response()->json($forum, 200);
    }

    // Menambah forum baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'forum_topic' => 'required|string|max:255'
        ]);

        // Membuat forum baru
        $forum = Forum::create($request->all());

        return response()->json([
            'message' => 'Forum created successfully',
            'forum' => $forum
        ], 201);
    }

    // Mengupdate forum
    public function update(Request $request, $id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        // Validasi input
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'forum_topic' => 'required|string|max:255'
        ]);

        // Update forum
        $forum->update($request->all());

        return response()->json([
            'message' => 'Forum updated successfully',
            'forum' => $forum
        ], 200);
    }

    // Menghapus forum
    public function destroy($id)
    {
        $forum = Forum::find($id);

        if (!$forum) {
            return response()->json(['message' => 'Forum not found'], 404);
        }

        $forum->delete();

        return response()->json(['message' => 'Forum deleted successfully'], 200);
    }
}