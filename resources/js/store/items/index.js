import mutations from "./mutations";
import actions from "./actions";
import state from "./state";
import getter from "./getter";
export default {
    isRegistered: false,
    namespaced: true,
    mutations,
    actions,
    getter,
    state,
};
