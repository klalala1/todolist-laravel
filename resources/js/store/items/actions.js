// import axios from "../../axios.js";
import axios from "axios";
export default {
    getItems({ commit }, header) {
        // console.log("aaa", header);
        return new Promise((resolve, reject) => {
            axios
                .get("api/items", header)
                .then((res) => {
                    commit("setItems", res.data);
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    createItem({ commit }, body) {
        return new Promise((resolve, reject) => {
            axios
                .post("api/items", { item: body })
                .then((res) => {
                    commit("setItems", res.data);
                    commit("setDates");
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    doneTodo({ commit }, id) {
        return new Promise((resolve, reject) => {
            axios
                .get(`api/items/${id.id}`)
                .then((res) => {
                    commit("removeOneItem", res.data);
                    commit("setDates");
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    editTodo({ commit }, item) {
        return new Promise((resolve, reject) => {
            axios
                .put(`api/items/${item.id}`, { item })
                .then((res) => {
                    commit("setOneItem", res.data);
                    commit("setDates");
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    deleteTodo({ commit }, item) {
        return new Promise((resolve, reject) => {
            axios
                .delete(`api/items/${item.id}`)
                .then((res) => {
                    commit("removeOneItem", item);
                    commit("setDates");
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    getCompleted({ commit }, header) {
        // console.log("thisone", header);
        return new Promise((resolve, reject) => {
            axios
                .get("api/items", header)
                .then((res) => {
                    resolve(res);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
};
