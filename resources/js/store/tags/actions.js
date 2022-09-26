// import axios from "../../axios.js";
import axios from "axios";
export default {
    getTags({ state }, username) {
        return new Promise((resolve, reject) => {
            axios
                .get("api/tags", {
                    headers: { username: username },
                })
                .then((res) => {
                    // console.log(res);
                    resolve(res.data);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
    createTag({ commit }, tag) {
        return new Promise((resolve, reject) => {
            axios
                .post("api/tags", { tag: tag.tag, username: tag.username })
                .then((res) => {
                    commit("addTag", res.data.tag_name);
                    resolve(res.data);
                })
                .catch((er) => {
                    reject(er);
                });
        });
    },
};
