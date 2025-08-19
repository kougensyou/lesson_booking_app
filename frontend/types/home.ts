import type { Lesson } from '~/types/common';

export interface LessonBooking {
  id: number;
  start_time: string;
  done_flag: boolean;
}

export interface Info {
  id: number;
  name: string;
  kind: boolean;
  image_url: string;
  link_url: string;
  visible_flag: boolean;
  sort_order: number;
}

export interface HomeData {
  next_lesson_list: Lesson[];
  selected_lesson_list: LessonBooking[];
  info_list: {
    slider_info: Info[];
    grid_info: Info[];
    list_info: Info[];
  };
}

export interface Attribute {
  dates: Date;
  customData: {
    done_flag: boolean;
  };
}
