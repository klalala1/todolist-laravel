import axios from "axios";

axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";
axios.defaults.headers.common["Access-Control-Allow-Methods"] =
    "GET, PUT, POST, DELETE, OPTIONS, post, get";
axios.defaults.headers.common["Access-Control-Allow-Credentials"] = "true";
axios.defaults.headers.common["withCredentials"] = "true";
axios.defaults.headers.common["Access-Control-Allow-Origin"] = "*";

const axiosCreate = axios.create({
    baseURL: `/`,
});
axiosCreate.interceptors.request.use(
    (config) => {
        config.headers.Authorization = `Bearer ${
            localStorage.authToken == null ? null : localStorage.authToken
        }`;
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);
export default axiosCreate;
