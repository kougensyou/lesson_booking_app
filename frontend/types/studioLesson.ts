export interface StudioLesson {
  density_level: string;
  start_time: string;
  lesson_name: string;
  instructor_name: string;
}

export type LessonSchedule = Record<string, StudioLesson[]>; // '07:00'などの時間

export type LessonsByDate = Record<string, LessonSchedule>; // '2025-08-11'などの日付

export interface StudioLessonData {
  time_options: string[];
  selected_date: string;
  selected_dates: string[];
  lessons_by_date: LessonsByDate[];
}

export interface WeekData {
  date: string;
  day: number;
  label: string;
  active: boolean;
}
