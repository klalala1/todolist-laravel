// import axios from "../../axios.js";
import axios from "../../axios";
export default {
    getItems() {
        return new Promise((resolve, reject) => {
            axios
                .get("api/items")
                .then((res) => {
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    sendLoginRequest({ commit }, data) {
        return new Promise((resolve, reject) => {
            axios
                .post("api/login", data)
                .then((response) => {
                    commit("setUserData", response.data.user);
                    localStorage.setItem("authToken", response.data.token);
                    resolve(response);
                })
                .catch((er) => reject(er));
        });
    },
    // registerUser({ commit, state }, user) {
    //     return new Promise((resolve, reject) => {
    //         axios
    //             .post("api/register", {
    //                 username: user.username,
    //                 email: user.email,
    //                 password: user.password,
    //             })
    //             .then((res) => {
    //                 resolve(res);
    //             })
    //             .catch((er) => {
    //                 reject(er);
    //             });
    //     });
    // },
    authUser({ commit, state }, user) {
        return new Promise((resolve, reject) => {
            axios
                .get("api/user", {})
                .then((res) => {
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    registerUser({ commit, dispatch }, data) {
        commit("setErrors", {}, { root: true });
        return new Promise((resolve, reject) => {
            axios
                .post("api/register", data)
                .then(async (response) => {
                    commit("setUserData", response.data.user);
                    localStorage.setItem("authToken", response.data.token);
                    await dispatch("sendLoginRequest", {
                        email: data.email,
                        password: data.password,
                    });
                    resolve(response);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    },
    async sendLogoutRequest({ commit }) {
        let returning;
        await axios
            .post("api/logout", {})
            .then((res) => {
                commit("setUserData", null);
                localStorage.removeItem("authToken");
                returning = res.date;
            })
            .catch((err) => {
                returning = err.message;
            });
        return returning;
    },
    getUserData({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get("api/user")
                .then((response) => {
                    // console.log(response);
                    commit("setUserData", response.data);
                    resolve(response);
                })
                .catch((err) => {
                    // console.log(err);
                    // localStorage.removeItem("authToken");
                });
        });
    },
    sendVerifyResendRequest({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get("api/email/resend").then((res) => {
                {
                    resolve(res);
                }
            });
        });
    },
    sendVerifyRequest({ dispatch }, data) {
        return new Promise((resolve, reject) => {
            axios
                .get(
                    `http://${window.location.host}/api/email/verify/` +
                        data.hash
                )
                .then((res) => {
                    // console.log(res);
                    resolve(res);
                    // dispatch("getUserData");
                })
                .catch((err) => {
                    // console.log(err);
                });
        });
    },
};
