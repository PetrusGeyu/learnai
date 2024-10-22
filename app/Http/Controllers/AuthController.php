<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi data input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  // validasi email unik
            'password' => 'required|min:8',  // minimal panjang password 8 karakter
            'role' => 'required|in:siswa,guru,orang tua',  // validasi role
            'learning_style' => 'nullable|in:visual,auditori,kinestetik'  // opsional, dengan validasi nilai tertentu
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'learning_style' => $request->learning_style,
        ]);

        // Membuat token API untuk pengguna
        $token = $user->createToken('login_tokens')->plainTextToken;

        // Mengembalikan respons dalam bentuk JSON
        return response()->json([
            'message' => 'Register successful',  // pesan sukses
            'token' => $token,  // token API
            'user' => $user,  // data pengguna
        ], 201);  // kode status HTTP 201 untuk "Created"
    }


    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan nama
        $user = User::where('name', $request->name)->first();

        // Cek apakah user ada dan password benar
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid username or password'  // pesan kesalahan
            ], 401);  // Kode status 401 untuk Unauthorized
        }

        // Jika berhasil, buat token dan kirim respons
        return response()->json([
            'message' => 'Login successful',  // pesan sukses
            'user' => $user,  // kirim data user
            'token' => $user->createToken('login_tokens')->plainTextToken  // kirim token API
        ], 200);  // Kode status 200 untuk OK
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Logout Succesfull'
        ]);
    }
}
