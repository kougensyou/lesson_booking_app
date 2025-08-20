<?php
use App\Http\Controllers\LessonController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\LessonCalendarController;
use App\Http\Controllers\LessonBookingController;
use App\Http\Controllers\LessonDetailController;
use App\Http\Controllers\StudioLessonController;
use App\Http\Controllers\BookDoneController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('get_next_lesson_data', [LessonController::class , 'getNextLessonData']);
    Route::get('get_information_list', [InformationController::class , 'getInformationList']);
    Route::get('get_selected_lesson_list', [LessonCalendarController::class , 'getSelectedLessonList']);
    Route::get('get_lesson_booking_data', [LessonBookingController::class , 'getLessonBookingData']);
    Route::post('search_lessons', [LessonBookingController::class , 'searchLessons']);
    Route::get('get_studio_lesson_data', [StudioLessonController::class , 'getStudioLessonData']);
    Route::get('get_lesson_detail', [LessonDetailController::class , 'getLessonDetail']);
    Route::post('book_lesson', [LessonDetailController::class , 'bookLesson']);
    Route::post('cancel_lesson', [LessonDetailController::class , 'cancelLesson']);
    Route::get('get_book_done_data', [BookDoneController::class , 'getBookDoneData']);
});
