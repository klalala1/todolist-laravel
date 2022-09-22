import LandingPage from "../pages/LandingPage";
import HomePage from "../pages/HomePage";
import Verify from "../pages/Verify";
import ExampleComponent from "../components/ExampleComponent";
const auth = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/login");
    }
};
const routes = [
    {
        path: "/",
        name: "LandingPage",
        component: LandingPage,
    },
    {
        path: "/HomePage",
        name: "HomePage",
        component: HomePage,
    },
    {
        path: "/verify/:hash",
        name: "Verify",
        beforeEnter: auth,
        props: true,
        component: Verify,
    },
    {
        path: "/completed",
        name: "ExampleComponent",
        component: ExampleComponent,
    },
    // // {
    // //     path: "/example",
    // //     name: "Example",
    // //     component: () => import("./components/ExampleComponent.vue"),
    // // },
    // { path: "/:catchAll(.*)", name: "All", component: App },
    // {
    //     // path: "*",
    //     path: "/:catchAll(.*)",
    //     name: "NotFound",
    //     component: App,
    //     meta: {
    //         requiresAuth: false,
    //     },
    // },
];
export default routes;
