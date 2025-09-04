<?php
use App\Http\Controllers\LessonController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\LessonBookingController;
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
    Route::get('get_selected_lesson_list', [LessonBookingController::class , 'getSelectedLessonList']);
    Route::get('get_studio_list', [StudioController::class , 'getStudioList']);
    Route::get('get_favorite_studio_list', [StudioController::class , 'getFavoriteStudioList']);
    Route::get('get_lesson_booking_data', [LessonBookingController::class , 'getLessonBookingData']);
    Route::get('add_same_studio_lesson_list', [LessonController::class , 'addSameStudioLessonList']);
    Route::get('get_search_input_data', [LessonController::class , 'getSearchInputData']);
    Route::get('add_searched_lessons', [LessonController::class , 'addSearchedLessons']);
    Route::get('get_studio_lesson_data', [LessonController::class , 'getStudioLessonData']);
    Route::get('get_lesson_detail', [LessonController::class , 'getLessonDetail']);
    Route::post('book_lesson', [LessonBookingController::class , 'bookLesson']);
    Route::post('cancel_lesson', [LessonBookingController::class , 'cancelLesson']);
    Route::get('add_booking_history', [LessonBookingController::class , 'addBookingHistory']);
    Route::post('save_favorite_studio_list', [StudioController::class , 'saveFavoriteStudioList']);
});
