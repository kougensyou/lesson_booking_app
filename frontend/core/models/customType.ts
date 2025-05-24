export {};

declare module "vue" {
  export interface ComponentCustomProperties {
    $routes: { [prop: string]: string };
  }
}
