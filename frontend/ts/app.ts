/* --------------------------------------------------------------
 * Import
 *-------------------------------------------------------------- */
import { createApp } from "vue";
import "../sass/app.scss";
import App from "./App.vue";
import router from "./router";

import VueDatePicker from "@vuepic/vue-datepicker";
import SessionErrorComponent from "./components/errors/403Component.vue";
import NotFoundErrorComponent from "./components/errors/404Component.vue";
import ServerErrorComponent from "./components/errors/500Component.vue";
import PageTitleComponent from "./components/pageParts/common/PageTitleComponent.vue";
import PageSubTitleComponent from "./components/pageParts/common/PageSubTitleComponent.vue";
import BreadcrumbComponent from "./components/pageParts/common/BreadcrumbComponent.vue";
import ExecutionButtonComponent from "./components/pageParts/common/ExecutionButtonComponent.vue";
import ItemCountComponent from "./components/pageParts/common/ItemCountComponent.vue";
import PageBackComponent from "./components/pageParts/common/PageBackComponent.vue";
import MessageDialogComponent from "./components/pageParts/common/MessageDialogComponent.vue";
import ModalComponent from "./components/pageParts/common/ModalComponent.vue";
import LoadingComponent from "./components/pageParts/common/LoadingComponent.vue";
import PaginationComponent from "./components/pageParts/common/PaginationComponent.vue";
import ErrorModalComponent from "./components/pageParts/common/error/ErrorModalComponent.vue";
import ErrorMessageComponent from "./components/pageParts/common/error/ErrorMessageComponent.vue";
import ErrorListComponent from "./components/pageParts/common/error/ErrorListComponent.vue";
import McommonSelectBoxComponent from "./components/pageParts/common/form/McommonSelectBoxComponent.vue";
import SearchButtonComponent from "./components/pageParts/common/form/SearchButtonComponent.vue";
import SuggestFormComponent from "./components/pageParts/common/form/SuggestFormComponent.vue";
import ProgressBar from "./components/pageParts/common/ProgressBar.vue";
import TabComponent from "./components/pageParts/common/TabComponent.vue";
import SidebarComponent from "./components/pageParts/common/SidebarComponent.vue";
import HeaderComponent from "./components/pageParts/common/HeaderComponent.vue";
import DeliveryHistoryComponent from "./components/pageParts/deliveryHistory/DeliveryHistoryComponent.vue";

/* --------------------------------------------------------------
 * Routing
 *-------------------------------------------------------------- */

/* --------------------------------------------------------------
 * Instance
 *-------------------------------------------------------------- */
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
app.component("DeliveryHistoryComponent", DeliveryHistoryComponent);
app.component("SessionErrorComponent", SessionErrorComponent);
app.component("NotFoundErrorComponent", NotFoundErrorComponent);
app.component("ServerErrorComponent", ServerErrorComponent);

/* --------------------------------------------------------------
 * Setting
 *-------------------------------------------------------------- */
app.use(router);
router.isReady().then(() => app.mount("#app"));
