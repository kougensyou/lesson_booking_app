export interface Lesson {
  id: number;
  done_flag: boolean;
  studio_name: string;
  lesson_name: string;
  start_time: string;
  end_time: string;
  lesson_time: string;
  instructor_name: string;
  image_path: string;
  image_url: string;
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

export interface HomeData {
  next_lesson_list: Lesson[];
  lesson_list_this_month: LessonBooking[];
  info_list: {
    slider_info: Info[];
    grid_info: Info[];
  };
}
