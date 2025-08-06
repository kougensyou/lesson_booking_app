export interface FavoriteStudio {
  id: number;
  studio_name: string;
  image_url: string;
}

export interface Studio {
  id: number;
  studio_name: string;
}

export interface LessonCategory {
  id: number;
  category_name: string;
}

export interface LessonBookingData {
  favorite_studio_list: FavoriteStudio[];
  studio_list: Studio[];
  lesson_category_list: LessonCategory[];
}
