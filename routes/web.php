<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BallotController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\ApplicationController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/index', function () {
    return view('index');
});
Route::get('/403-error', function () {
    return view('error.403');
})->name('error.403');


Auth::routes();


Route::group(['middleware' => ['auth']], function () { 
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('editprofile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/results', [ResultController::class, 'index'])->name('candidates.result');
    Route::get('/settings', function () {
        return view('auth.settings');
    })->name('auth.settings');
    Route::get('/export-pdf', [ResultController::class, 'exportVotesDataToPDF']);

});
Route::group(['middleware' => ['auth', 'admin']], function () {   //check if user is logged in else display login page

Route::get('/users/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('createadmin', [AdminController::class, 'store'])->name('admin.create');
Route::post('editadmin', [AdminController::class, 'update'])->name('admin.update');
Route::post('deleteadmin', [AdminController::class, 'destroy'])->name('admin.delete');

Route::get('/users/students', [StudentController::class, 'index'])->name('admin.students');
Route::post('editstudent', [StudentController::class, 'update'])->name('student.update');
Route::post('deletestudent', [StudentController::class, 'destroy'])->name('student.delete');


Route::get('/applications', [ApplicationController::class, 'index'])->name('admin.application');
Route::post('createapplication', [ApplicationController::class, 'store'])->name('application.create');
Route::post('editapplication', [ApplicationController::class, 'update'])->name('application.update');
Route::post('deleteapplication', [ApplicationController::class, 'destroy'])->name('application.delete');

Route::get('/positions', [PositionsController::class, 'index'])->name('admin.position');
Route::post('createposition', [PositionsController::class, 'store'])->name('position.create');
Route::post('editposition', [PositionsController::class, 'update'])->name('position.update');
Route::post('deleteposition', [PositionsController::class, 'destroy'])->name('position.delete');


});

Route::group(['middleware' => ['auth', 'student']], function () {   //check if user is logged in else display login page
    
    Route::get('/ballot', [BallotController::class, 'index'])->name('ballot');
    Route::post('castvote', [BallotController::class, 'store'])->name('ballot.vote');

    Route::get('/candidates', [CandidateController::class, 'index'])->name('students.candidates');
    
});