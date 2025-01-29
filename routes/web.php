<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Default route
Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/dashboard', [PhotoController::class, 'dashboard'])->name('dashboard');
    Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
});

// Role-based routes for student and teacher
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/students', [StudentController::class, 'list'])->name('students.list'); // List students
    Route::get('/friends', [StudentController::class, 'friends'])->name('student.friends');
    Route::get('/mutual-friends', [StudentController::class, 'mutualFriends'])->name('student.mutual-friends');
});

// Teacher routes
Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

    // CRUD routes for managing student data
    Route::get('/teacher/students', [StudentController::class, 'index'])->name('teacher.students.index'); // List all students
    Route::get('/teacher/students/{id}', [StudentController::class, 'show'])->name('teacher.students.show'); // Show specific student
    Route::put('/teacher/students/{id}', [StudentController::class, 'update'])->name('teacher.students.update'); // Update student
    Route::delete('/teacher/students/{id}', [StudentController::class, 'destroy'])->name('teacher.students.destroy'); // Delete student
});

// Friend Request Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/student/pending-requests', [FriendRequestController::class, 'pendingRequests'])->name('friend-request.pending');
    Route::post('/friend-request/send', [FriendRequestController::class, 'send'])->name('friend-request.send'); // Send request
    Route::post('/friend-request/accept', [FriendRequestController::class, 'accept'])->name('friend-request.accept'); // Accept request
    Route::post('/friend-request/reject', [FriendRequestController::class, 'reject'])->name('friend-request.reject'); // Reject request
});

// Chat Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat/{friendId}', [ChatController::class, 'index'])->name('chat.index'); // Open chat
    Route::post('/chat/{friendId}/send', [ChatController::class, 'send'])->name('chat.send'); // Send message
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
