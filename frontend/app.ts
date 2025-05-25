/* --------------------------------------------------------------
 * Import
 *-------------------------------------------------------------- */
import { createApp } from "vue";
import { createPinia } from 'pinia'
import "./scss/app.scss";
import App from "./App.vue";
import router from "./router";

import VueDatePicker from "@vuepic/vue-datepicker";
import SessionErrorComponent from "./core/components/error/403Component.vue";
import NotFoundErrorComponent from "./core/components/error/404Component.vue";
import ServerErrorComponent from "./core/components/error/500Component.vue";
import PageTitleComponent from "./core/components/PageTitleComponent.vue";
import PageSubTitleComponent from "./core/components/PageSubTitleComponent.vue";
import BreadcrumbComponent from "./core/components/BreadcrumbComponent.vue";
import ExecutionButtonComponent from "./core/components/ExecutionButtonComponent.vue";
import ItemCountComponent from "./core/components/ItemCountComponent.vue";
import PageBackComponent from "./core/components/PageBackComponent.vue";
import MessageDialogComponent from "./core/components/MessageDialogComponent.vue";
import ModalComponent from "./core/components/ModalComponent.vue";
import LoadingComponent from "./core/components/LoadingComponent.vue";
import PaginationComponent from "./core/components/PaginationComponent.vue";
import ErrorModalComponent from "./core/components/error/ErrorModalComponent.vue";
import ErrorMessageComponent from "./core/components/error/ErrorMessageComponent.vue";
import ErrorListComponent from "./core/components/error/ErrorListComponent.vue";
import McommonSelectBoxComponent from "./core/components/form/McommonSelectBoxComponent.vue";
import SearchButtonComponent from "./core/components/form/SearchButtonComponent.vue";
import SuggestFormComponent from "./core/components/form/SuggestFormComponent.vue";
import ProgressBar from "./core/components/ProgressBar.vue";
import TabComponent from "./core/components/TabComponent.vue";
import SidebarComponent from "./core/components/SidebarComponent.vue";
import HeaderComponent from "./core/components/HeaderComponent.vue";

/* --------------------------------------------------------------
 * Routing
 *-------------------------------------------------------------- */

/* --------------------------------------------------------------
 * Instance
 *-------------------------------------------------------------- */
const pinia = createPinia();
const app = createApp(App);

/* --------------------------------------------------------------
 * Component
 *-------------------------------------------------------------- */
// common
app.component("PageTitleComponent", PageTitleComponent);
app.component("PageSubtitleComponent", PageSubTitleComponent);
app.component("BreadcrumbComponent", BreadcrumbComponent);
app.component("ExecutionButtonComponent", ExecutionButtonComponent);
app.component("ItemCountComponent", ItemCountComponent);
app.component("PageBackComponent", PageBackComponent);
app.component("MessageDialogComponent", MessageDialogComponent);
app.component("ModalComponent", ModalComponent);
app.component("LoadingComponent", LoadingComponent);
app.component("PaginationComponent", PaginationComponent);
app.component("ErrorModalComponent", ErrorModalComponent);
app.component("ErrorMessageComponent", ErrorMessageComponent);
app.component("ErrorListComponent", ErrorListComponent);
app.component("McommonSelectBoxComponent", McommonSelectBoxComponent);
app.component("FormSearchButtonComponent", SearchButtonComponent);
app.component("SuggestFormComponent", SuggestFormComponent);
app.component("ProgressbarComponent", ProgressBar);
app.component("TabComponent", TabComponent);
app.component("VueDatePicker", VueDatePicker);
app.component("SidebarComponent", SidebarComponent);
app.component("HeaderComponent", HeaderComponent);
app.component("SessionErrorComponent", SessionErrorComponent);
app.component("NotFoundErrorComponent", NotFoundErrorComponent);
app.component("ServerErrorComponent", ServerErrorComponent);

/* --------------------------------------------------------------
 * Setting
 *-------------------------------------------------------------- */
app.use(router);
app.use(pinia);
router.isReady().then(() => app.mount("#app"));
