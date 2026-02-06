export interface Info {
  id: number;
  name: string;
  kind: boolean;
  image_url: string;
  image_path: string;
  link_url: string;
  visible_flag: boolean;
  sort_order: number;
}

export interface InformationData {
  slider_info: Info[];
  grid_info: Info[];
  list_info: Info[];
}
