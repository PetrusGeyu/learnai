<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\StudentAssessmentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::prefix('v1')->group(function () {
//     Route::post('auth/register', [AuthController::class, 'register']);
//     Route::post('auth/login', [AuthController::class, 'login']);

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::post('auth/logout', [AuthController::class, 'logout']);

//         Route::get('courses', [CourseController::class, 'index']);  // Menampilkan semua course
//         Route::get('courses/{id}', [CourseController::class, 'show']);  // Menampilkan detail course
//         Route::post('courses', [CourseController::class, 'store']);  // Membuat course baru
//         Route::put('courses/{id}', [CourseController::class, 'update']);  // Mengupdate course
//         Route::delete('courses/{id}', [CourseController::class, 'destroy']);  // Menghapus course

//         Route::get('lessons', [LessonController::class, 'index']);  // Menampilkan semua lesson
//         Route::get('lessons/{id}', [LessonController::class, 'show']);  // Menampilkan detail lesson
//         Route::post('lessons', [LessonController::class, 'store']);  // Membuat lesson baru
//         Route::put('lessons/{id}', [LessonController::class, 'update']);  // Mengupdate lesson
//         Route::delete('lessons/{id}', [LessonController::class, 'destroy']);  // Menghapus lesson

//         Route::get('assessments', [AssessmentController::class, 'index']);  // Menampilkan semua assessment
//         Route::get('assessments/{id}', [AssessmentController::class, 'show']);  // Menampilkan detail assessment
//         Route::post('assessments', [AssessmentController::class, 'store']);  // Membuat assessment baru
//         Route::put('assessments/{id}', [AssessmentController::class, 'update']);  // Mengupdate assessment
//         Route::delete('assessments/{id}', [AssessmentController::class, 'destroy']);  // Menghapus assessment

//         Route::get('questions', [QuestionController::class, 'index']);  // Menampilkan semua questions
//         Route::get('questions/{id}', [QuestionController::class, 'show']);  // Menampilkan detail question
//         Route::post('questions', [QuestionController::class, 'store']);  // Membuat question baru
//         Route::put('questions/{id}', [QuestionController::class, 'update']);  // Mengupdate question
//         Route::delete('questions/{id}', [QuestionController::class, 'destroy']);  // Menghapus question

//         Route::get('feedbacks', [FeedbackController::class, 'index']);  // Menampilkan semua feedback
//         Route::get('feedbacks/{id}', [FeedbackController::class, 'show']);  // Menampilkan detail feedback
//         Route::post('feedbacks', [FeedbackController::class, 'store']);  // Membuat feedback baru
//         Route::put('feedbacks/{id}', [FeedbackController::class, 'update']);  // Mengupdate feedback
//         Route::delete('feedbacks/{id}', [FeedbackController::class, 'destroy']);  // Menghapus feedback

//         Route::get('student-assessments', [StudentAssessmentController::class, 'index']);  // Menampilkan semua student assessment
//         Route::get('student-assessments/{id}', [StudentAssessmentController::class, 'show']);  // Menampilkan detail student assessment
//         Route::post('student-assessments', [StudentAssessmentController::class, 'store']);  // Membuat student assessment baru
//         Route::put('student-assessments/{id}', [StudentAssessmentController::class, 'update']);  // Mengupdate student assessment
//         Route::delete('student-assessments/{id}', [StudentAssessmentController::class, 'destroy']);  // Menghapus student assessment

//         Route::get('progresses', [ProgressController::class, 'index']);  // Menampilkan semua progress
//         Route::get('progresses/{id}', [ProgressController::class, 'show']);  // Menampilkan detail progress
//         Route::post('progresses', [ProgressController::class, 'store']);  // Membuat progress baru
//         Route::put('progresses/{id}', [ProgressController::class, 'update']);  // Mengupdate progress
//         Route::delete('progresses/{id}', [ProgressController::class, 'destroy']);  // Menghapus progress

//         Route::get('forums', [ForumController::class, 'index']);  // Menampilkan semua forum
//         Route::get('forums/{id}', [ForumController::class, 'show']);  // Menampilkan detail forum
//         Route::post('forums', [ForumController::class, 'store']);  // Membuat forum baru
//         Route::put('forums/{id}', [ForumController::class, 'update']);  // Mengupdate forum
//         Route::delete('forums/{id}', [ForumController::class, 'destroy']);  // Menghapus forum

//         Route::get('forums/{forumId}/posts', [ForumPostController::class, 'index']);  // Menampilkan semua post dalam forum
//         Route::get('posts/{id}', [ForumPostController::class, 'show']);  // Menampilkan detail post
//         Route::post('posts', [ForumPostController::class, 'store']);  // Membuat post baru
//         Route::put('posts/{id}', [ForumPostController::class, 'update']);  // Mengupdate post
//         Route::delete('posts/{id}', [ForumPostController::class, 'destroy']);  // Menghapus post
//     });
// });

Route::prefix('v1')->group(function () {
    // Route untuk registrasi dan login
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // Semua route di bawah ini memerlukan autentikasi menggunakan Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // Logout
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // ----------- Route Khusus Guru -----------
        Route::middleware('role:guru')->group(function () {
            // Courses - Guru bisa membuat, mengupdate, dan menghapus course
            Route::post('courses', [CourseController::class, 'store']);
            Route::put('courses/{id}', [CourseController::class, 'update']);
            Route::delete('courses/{id}', [CourseController::class, 'destroy']);

            // Lessons - Guru bisa membuat, mengupdate, dan menghapus lesson
            Route::post('lessons', [LessonController::class, 'store']);
            Route::put('lessons/{id}', [LessonController::class, 'update']);
            Route::delete('lessons/{id}', [LessonController::class, 'destroy']);

            // Assessment - Guru bisa mengelola assessment
            Route::post('assessments', [AssessmentController::class, 'store']);
            Route::put('assessments/{id}', [AssessmentController::class, 'update']);
            Route::delete('assessments/{id}', [AssessmentController::class, 'destroy']);

            // Questions - Guru bisa mengelola questions dalam assessment
            Route::post('questions', [QuestionController::class, 'store']);
            Route::put('questions/{id}', [QuestionController::class, 'update']);
            Route::delete('questions/{id}', [QuestionController::class, 'destroy']);

            // Forum - Guru bisa mengelola forum
            Route::post('forums', [ForumController::class, 'store']);
            Route::put('forums/{id}', [ForumController::class, 'update']);
            Route::delete('forums/{id}', [ForumController::class, 'destroy']);
        });

        // ----------- Route Khusus Siswa -----------
        Route::middleware('role:siswa')->group(function () {
            // Mengakses courses
            Route::get('courses', [CourseController::class, 'index']);
            Route::get('courses/{id}', [CourseController::class, 'show']);

            // Mengakses lessons
            Route::get('lessons', [LessonController::class, 'index']);
            Route::get('lessons/{id}', [LessonController::class, 'show']);

            // Mengakses assessments
            Route::get('assessments', [AssessmentController::class, 'index']);
            Route::get('assessments/{id}', [AssessmentController::class, 'show']);

            // Mengakses questions dalam assessment
            Route::get('questions', [QuestionController::class, 'index']);
            Route::get('questions/{id}', [QuestionController::class, 'show']);

            // Mengelola student assessments
            Route::post('student-assessments', [StudentAssessmentController::class, 'store']);
            Route::put('student-assessments/{id}', [StudentAssessmentController::class, 'update']);
            Route::delete('student-assessments/{id}', [StudentAssessmentController::class, 'destroy']);

            // Mengelola progress siswa
            Route::get('progresses', [ProgressController::class, 'index']);
            Route::get('progresses/{id}', [ProgressController::class, 'show']);
            Route::post('progresses', [ProgressController::class, 'store']);
            Route::put('progresses/{id}', [ProgressController::class, 'update']);
            Route::delete('progresses/{id}', [ProgressController::class, 'destroy']);

            // Mengakses forum
            Route::get('forums', [ForumController::class, 'index']);
            Route::get('forums/{id}', [ForumController::class, 'show']);
            Route::get('forums/{forumId}/posts', [ForumPostController::class, 'index']);
            Route::get('posts/{id}', [ForumPostController::class, 'show']);
            Route::post('posts', [ForumPostController::class, 'store']);
            Route::put('posts/{id}', [ForumPostController::class, 'update']);
            Route::delete('posts/{id}', [ForumPostController::class, 'destroy']);
        });

        // ----------- Route Khusus Admin -----------
        Route::middleware('role:admin')->group(function () {
            // Admin bisa mengelola semua data (courses, lessons, users, etc.)
            Route::apiResource('courses', CourseController::class);
            Route::apiResource('lessons', LessonController::class);
            Route::apiResource('assessments', AssessmentController::class);
            Route::apiResource('questions', QuestionController::class);
            Route::apiResource('feedbacks', FeedbackController::class);
            Route::apiResource('forums', ForumController::class);
            Route::apiResource('student-assessments', StudentAssessmentController::class);
            Route::apiResource('progresses', ProgressController::class);
            Route::apiResource('forums.posts', ForumPostController::class);
        });
    });
});