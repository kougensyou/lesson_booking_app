<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Lesson;
use App\Models\LessonBooking;
use App\Models\LessonCategory;
use App\Models\Studio;
use App\Models\FavoriteStudio;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class LessonBookingRepository
{

    /**
     * Get a list of lessons for a given user and selected date
     * 
     * @param int $userId
     * @param \Illuminate\Support\Carbon $startOfMonth
     * @param \Illuminate\Support\Carbon $endOfMonth
     * 
     * @return Collection
     */
    public function getSelectedLessonList($userId, $startOfMonth, $endOfMonth): Collection
    {
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
     * Create a lesson booking record
     * 
     * @param array $insertData Data for the new lesson booking
     * 
     * @return void
     */
    public function createLessonBooking($insertData): void
    {
        LessonBooking::create($insertData);
    }

    /**
     * Cancel a lesson booking for a given user and lesson
     * 
     * @param int $userId User ID
     * @param int $lessonId Lesson ID
     * 
     * @return void
     */
    public function deleteLessonBooking($userId, $lessonId): void
    {
        LessonBooking::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->delete();
    }

    /**
     * Increment the booking user count for a lesson
     * 
     * @param int $lessonId Lesson ID
     * 
     * @return void
     */
    public function incrementBookingUserNum($lessonId): void
    {
        Lesson::where('id', $lessonId)
            ->increment('booking_user_num', 1);
    }

    /**
     * Decrement the booking user count for a lesson
     * 
     * @param int $lessonId Lesson ID
     * 
     * @return void
     */
    public function decrementBookingUserNum($lessonId): void
    {
        Lesson::where('id', $lessonId)
            ->decrement('booking_user_num', 1);
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
     */
    public function sendMail($firstBooking): void
    {
        $body = __('messages.first_lesson_booking', [
            'name' => $firstBooking['user']['name'], 
            'studio_name' => $firstBooking['selected_lesson']['studio_name'], 
            'lesson_name' => $firstBooking['selected_lesson']['lesson_name'], 
            'lesson_datetime' => $firstBooking['selected_lesson']['lesson_day'] . ' ' . $firstBooking['selected_lesson']['lesson_time'],
        ]);

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = getenv('MAIL_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('MAIL_USERNAME');
        $mail->Password   = getenv('MAIL_APPPASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = getenv('MAIL_PORT');

        $mail->setFrom(getenv('SENDER_MAILADDRESS'), 'Sender');
        $mail->addAddress($firstBooking['user']['email']);

        $mail->CharSet = 'UTF-8';
        $mail->isHTML(false);
        $mail->Subject = __('messages.first_lesson_booking_subject');
        $mail->Body    = $body;

        $mail->send();
    }


}
