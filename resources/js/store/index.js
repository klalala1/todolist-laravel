import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);

import user from "./user";
import items from "./items";
import tags from "./tags";
const store = new Vuex.Store({
    modules: {
        user,
        items,
        tags,
    },
});

export default store;
