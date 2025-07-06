export interface Lesson {
  id: number;
  lesson_name: string;
  lesson_date: string;
  instructor_name: string;
  instructor_image: string;
  studio_name: string;
}

export interface LessonBooking {
  id: number;
  lesson_date: string;
  done_flag: boolean;
}

export interface Info {
  id: number;
  name: string;
  kind: boolean;
  image_url: string;
  link_url: string;
}
