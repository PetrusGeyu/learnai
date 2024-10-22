<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    // Menampilkan semua post dari forum tertentu
    public function index($forumId)
    {
        $posts = ForumPost::where('forum_id', $forumId)->with('user')->get();

        return response()->json($posts, 200);
    }

    // Menampilkan detail post tertentu
    public function show($id)
    {
        $post = ForumPost::with('user')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post, 200);
    }

    // Membuat post baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'forum_id' => 'required|exists:forums,id',
            'user_id' => 'required|exists:users,id',
            'post_content' => 'required|string',
            'post_date' => 'required|date'
        ]);

        // Membuat post baru
        $post = ForumPost::create($request->all());

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    // Mengupdate post
    public function update(Request $request, $id)
    {
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Validasi input
        $request->validate([
            'forum_id' => 'required|exists:forums,id',
            'user_id' => 'required|exists:users,id',
            'post_content' => 'required|string',
            'post_date' => 'required|date'
        ]);

        // Update post
        $post->update($request->all());

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ], 200);
    }

    // Menghapus post
    public function destroy($id)
    {
        $post = ForumPost::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}