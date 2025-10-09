export interface SearchInputForm {
  instructor: string;
  lessonName: string;
  studio: number;
  lessonCategory: string;
  selectedDates: string[];
  startTime: string;
  endTime: string;
}

export interface LessonCategory {
  id: number;
  category_name: string;
}

export interface Lesson {
  id: number;
  studio_name: string;
  short_studio_name: string;
  lesson_name: string;
  short_lesson_name: string;
  start_time: string;
  end_time: string;
  lesson_time: string;
  instructor_name: string;
  image_path: string;
  image_url: string;
}

export interface TimeOptions {
  start_time_options: string[];
  end_time_options: string[];
}

export interface LessonDetail {
  id: number;
  studio_id: string;
  studio_name: string;
  lesson_name: string;
  lesson_explanation: string;
  lesson_image_path: string;
  lesson_image_url: string;
  start_time: string;
  end_time: string;
  lesson_day: string;
  lesson_time: string;
  lesson_datetime: string;
  instructor_name: string;
  instructor_introduction: string;
  instructor_image_path: string;
  instructor_image_url: string;
  booked_flag: boolean;
  done_flag: boolean;
  empty_flag: boolean;
}

export interface Studio {
  studio_name: string;
}

export interface SelectedWeekData {
  date: string;
  label: string;
}

export interface WeekData {
  dateObj: Date;
  date: string;
  day: number;
  label: string;
}
export interface BaseStudioLesson {
  lesson_id: number;
  empty_flag: boolean;
  lesson_day: string;
  lesson_time: string;
  start_time: string;
  lesson_name: string;
  instructor_name: string;
}

export type LessonSchedule = Record<string, BaseStudioLesson[]>;

export type StudioLesson = Record<string, LessonSchedule>;

export interface StudioLessonData {
  time_options: string[];
  studio_data: Studio;
  studio_lesson_list: StudioLesson;
}
