export default {
    setUser(state, user) {
        state.user = user;
    },
    changeHomeModal(state) {
        state.homeModal = state.homeModal !== "register" ? "register" : "login";
    },
    setUserData(state, user) {
        state.userData = user;
    },
    setErrors(state, errors) {
        state.errors = errors;
    },
    setError(state, error) {
        state.error = error;
    },
    resetError(state) {
        state.error = null;
    },
};
