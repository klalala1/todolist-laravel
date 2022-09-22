// require("./bootstrap");
import VueRouter from "vue-router";
import App from "../components/app";
import Vue from "vue";
import ExampleComponent from "../components/ExampleComponent";
import routes from "./router";
Vue.use(VueRouter);

// const routes = [
//     { path: "/*", component: App },
//     { path: "/test", component: ExampleComponent },
// ];
// const routes = [
//     {
//         path: "/",
//         name: "App",
//         component: App,
//     },
//     {
//         path: "/test",
//         name: "ExampleComponent",
//         component: ExampleComponent,
//     },
// ];
const router = new VueRouter({
    mode: "history",
    base: "/",
    routes: routes,
});
export default router;
