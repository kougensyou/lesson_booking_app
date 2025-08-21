export interface LessonBooking {
  id: number;
  start_time: string;
  done_flag: boolean;
}

export interface Attribute {
  dates: Date;
  customData: {
    done_flag: boolean;
  };
}
