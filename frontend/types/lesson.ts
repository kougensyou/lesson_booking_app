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
  lesson_name: string;
  start_time: string;
  end_time: string;
  lesson_time: string;
  instructor_name: string;
  image_path: string;
  image_url: string;
}

export interface SearchInputData {
  lesson_category_list: LessonCategory[];
  start_time_options: string[];
  end_time_options: string[];
}
