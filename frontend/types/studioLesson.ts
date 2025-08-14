export interface Studio {
  studio_name: string;
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

export type LessonSchedule = Record<string, BaseStudioLesson[]>;

export type StudioLesson = Record<string, LessonSchedule>;

export interface StudioLessonData {
  time_options: string[];
  studio_data: Studio;
  studio_lesson_list: StudioLesson;
}
