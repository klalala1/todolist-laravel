import Vue from "vue";
import router from "./router/index";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

import Vuex from "vuex";
import store from "./store/index";

Vue.use(BootstrapVue);

Vue.use(IconsPlugin);
Vue.use(Vuex);

const app = new Vue({
    router,
    store: store,
}).$mount("#app");
