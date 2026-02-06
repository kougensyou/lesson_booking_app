export interface LessonBooking {
  id: number;
  start_time: string;
  done_flag: boolean;
}

export interface Attribute {
  dates: Date[];
  customData?: {
    done_flag: boolean;
  };
}

export interface FirstSelectedLesson {
  lesson_category_name: string;
  studio_name: string;
  lesson_day: string;
  lesson_time: string;
  lesson_name: string;
}

export interface FirstUser {
  name: string;
  email: string;
  birth_date: string;
}

export interface FirstBooking {
  selected_lesson: FirstSelectedLesson;
  user: FirstUser;
}
