export interface Studio {
  studio_name: string;
  yoga_or_pilates: string;
}

export interface WeekData {
  date: string;
  day: number;
  label: string;
  active: boolean;
}
export interface BaseStudioLesson {
  density_level: string;
  start_time: string;
  lesson_name: string;
  instructor_name: string;
}

export type LessonSchedule = Record<string, BaseStudioLesson[]>; // '07:00'などの時間

export type StudioLesson = Record<string, LessonSchedule>; // '2025-08-11'などの日付

export interface StudioLessonData {
  time_options: string[];
  studio_data: Studio;
  selected_date: string;
  selected_dates: string[];
  studio_lesson_list: StudioLesson[];
}
