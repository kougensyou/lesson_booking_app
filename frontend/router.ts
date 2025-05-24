import { createRouter, createWebHistory } from "vue-router";

import SessionErrorComponent from "./core/components/error/403Component.vue";
import NotFoundErrorComponent from "./core/components/error/404Component.vue";
import ServerErrorComponent from "./core/components/error/500Component.vue";
import LoginComponent from "./modules/common/views/LoginComponent.vue";
import LoginCallbackComponent from "./modules/common/views/LoginCallbackComponent.vue";
import LogoutComponent from "./modules/common/views/LogoutComponent.vue";

export default createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/:catchAll(.*)", component: NotFoundErrorComponent },

    // 401 Error
    { path: "/401", component: SessionErrorComponent },
    // 403 Error
    { path: "/403", component: SessionErrorComponent },
    // 404 Error
    { path: "/404", component: NotFoundErrorComponent },
    // 500 Error
    { path: "/500", component: ServerErrorComponent },
    // 502 Error
    { path: "/502", component: ServerErrorComponent },
    {
      path: "/login",
      component: LoginComponent,
      name: "login"
    },
    {
      path: "/login/callback",
      component: LoginCallbackComponent,
      name: "loginCallback"
    },
    {
      path: "/logout",
      component: LogoutComponent,
      name: "logout"
    }
    // Contents
  ],
  // 遷移にトップに移動
  scrollBehavior() {
    return { left: 0, top: 0 };
  }
});
