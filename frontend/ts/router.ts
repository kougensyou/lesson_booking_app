import { createRouter, createWebHistory } from "vue-router";

import SessionErrorComponent from "./components/errors/403Component.vue";
import NotFoundErrorComponent from "./components/errors/404Component.vue";
import ServerErrorComponent from "./components/errors/500Component.vue";
import DeliveryHistoryListComponent from "./components/pages/DeliveryHistoryListComponent.vue";
import LoginComponent from "./components/pages/LoginComponent.vue";
import LoginCallbackComponent from "./components/pages/LoginCallbackComponent.vue";
import LogoutComponent from "./components/pages/LogoutComponent.vue";

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
    },
    // Contents
    {
      path: "/delivery_history/list",
      component: DeliveryHistoryListComponent,
      name: "deliveryHistoryList",
      meta: {
        title: "配送履歴",
        heading: "配送履歴画面",
        breadcrumb: ["deliveryHistoryList"]
      }
    }
  ],
  // 遷移にトップに移動
  scrollBehavior() {
    return { left: 0, top: 0 };
  }
});
