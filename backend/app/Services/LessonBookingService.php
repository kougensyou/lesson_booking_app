<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use App\Models\Lesson;
use App\Models\LessonBooking;
use App\Models\LessonCategory;
use App\Models\Studio;
use App\Models\FavoriteStudio;
use SendGrid;


class LessonBookingService
{

    /**
     * Get a list of lessons for a given user and selected date
     * 
     * @param int $userId
     * @param int $selectedYear
     * @param int $selectedMonth
     * 
     * @return Collection
     */
    public function getSelectedLessonList($userId, $selectedYear, $selectedMonth): Collection
    {
        $startOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endOfMonth = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();
        return LessonBooking::with(['lesson:id,start_time'])
            ->where('user_id', $userId)
            ->whereHas('lesson', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_time', [$startOfMonth, $endOfMonth]);
            })
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'start_time' => $booking->lesson->start_time,
                    'done_flag' => (bool) $booking->done_flag,
                ];
            });
    }

    /**
     * Book a lesson for the authenticated user
     * 
     * @param int $lessonId
     * 
     * @throws \Throwable
     */
    public function bookLesson($lessonId): void
    {

        DB::beginTransaction();
        
        try {

            $now = Carbon::now();

            $insertData = [
                'booking_time' => $now,
                'lesson_id' => $lessonId,
                'user_id' => Auth::id(),
                'done_flag' => null,
                'created_at' => $now,
                'updated_at' => $now
            ];

            LessonBooking::create($insertData);

            Lesson::where('id', $lessonId)
            ->increment('booking_user_num', 1);

            DB::commit();
            
        } catch (\Throwable $e) {
            \DB::rollback();
            throw $e;
        }
    }

    /**
     * Cancel a lesson booking for a given user and lesson
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * 
     * @throws \Throwable
     */
    public function cancelLesson($userId, $lessonId): void
    {

        DB::beginTransaction();

        try {
            
            LessonBooking::where('user_id', $userId)
                ->where('lesson_id', $lessonId)
                ->delete();
            
            Lesson::where('id', $lessonId)
            ->decrement('booking_user_num', 1);

            DB::commit();
            
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get a list of booking history for a given user
     * 
     * @param int $userId User ID
     * 
     * @return LengthAwarePaginator
     */
    public function addBookingHistory($userId): LengthAwarePaginator
    {
        return LessonBooking::with(['lesson.studio', 'lesson.instructor'])
            ->where('user_id', $userId)
            ->where('done_flag', config('const.lessonBooking.lessonDone'))
            ->join('lesson', 'lesson_booking.lesson_id', '=', 'lesson.id')
            ->orderBy('lesson.start_time', 'asc')
            ->select('lesson_booking.*')
            ->paginate(config('const.lessonBooking.pagination'))
            ->through(function ($item) {
                $lesson = $item->lesson;
                $instructor = $lesson->instructor;
                $studio = $lesson->studio;
                $start = Carbon::parse($lesson->start_time);
                $end = Carbon::parse($lesson->end_time);

                return [
                    'id' => $lesson->id,
                    'studio_name' => $studio->studio_name,
                    'short_studio_name' => mb_strimwidth($studio->studio_name, 0, 10, ' ...'),
                    'lesson_name' => $lesson->name,
                    'short_lesson_name' => mb_strimwidth($lesson->name, 0, 15, ' ...'),
                    'start_time' => $lesson->start_time,
                    'end_time' => $lesson->end_time,
                    'lesson_time' => $start->format('n/j G:i') . ' - ' . $end->format('G:i'),
                    'instructor_name' => $instructor->name,
                    'image_path' => $instructor->image_path,
                    'image_url' => $instructor->image_path ? asset('storage/' . ltrim($instructor->image_path, '/')) : null,
                ];
            });
    }

    /**
     * Apply the first lesson booking
     * 
     * @param array $firstBooking Request data for the first lesson booking
     * 
     * @return RedirectResponse
     */
    public function applyFirstLesson($firstBooking): RedirectResponse
    {
        $body = __('messages.first_lesson_booking', [
            'name' => $firstBooking['user']['name'], 
            'studio_name' => $firstBooking['selected_lesson']['studio_name'], 
            'lesson_name' => $firstBooking['selected_lesson']['lesson_name'], 
            'lesson_datetime' => $firstBooking['selected_lesson']['lesson_day'] . ' ' . $firstBooking['selected_lesson']['lesson_time'],
        ]);

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(getenv('SENDGRID_FROM_EMAIL'));
        $email->setSubject(__('messages.first_lesson_booking_subject'));
        $email->addTo($firstBooking['user']['email']);
        $apiKey = getenv('SENDGRID_API_KEY');
        $sendGrid = new \SendGrid($apiKey);
        $email->addContent(
            "text/plain",
            $body
        );
        $response = $sendGrid->send($email);
        if ($response->statusCode() == 202) {
            return back()->with(['success' => "E-mails successfully sent out!!"]);
        }
        return back()->withErrors(json_decode($response->body())->errors);
    }


}