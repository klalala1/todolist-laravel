<template>
    <div class="home-container">
        <NavbarTodoList></NavbarTodoList>
        <div class="todo-holder">
            <span
                style="
                    position: fixed;
                    width: 100%;
                    top: 56px;
                    backdrop-filter: blur(12px);
                    z-index: 100;
                "
            >
                <div class="alert alert-success" role="alert" v-if="success">
                    {{ success }}
                </div>
                <div class="alert alert-danger" role="alert" v-if="error">
                    {{ error }}
                </div>
                <div
                    class="alert alert-danger"
                    role="alert"
                    v-if="
                        this.$store.state.user.userData &&
                        this.$store.state.user.userData.email_verified_at ==
                            null
                    "
                >
                    <!-- {{ success }} -->
                    Please verify your email address, We have sent you a
                    verification link in your email.<button
                        style="
                            color: black;
                            background-color: transparent;
                            border: none;
                            font-weight: 700;
                        "
                        @click="verifyResend()"
                    >
                        Resend
                    </button>
                </div>
                <h2 v-else-if="!this.$store.state.user.userData">
                    Welcome, please log in or register
                </h2>

                <!-- <h2 v-else-if="!this.$store.state.user.email_verified_at">
            Hello, {{ this.$store.state.user.username }}! Registration
            successful, please check your inbox and click confirmation link. If
            you did not receive the email, click
            <a href="#" @click="verifyResend">here</a> to request another
        </h2> -->
                <h2 v-if="this.$store.state.user.userData">
                    Hello, {{ this.$store.state.user.userData.username }}!
                    You're in.
                </h2>
                <!-- <button
                    class="btn btn-outline-light btn-lg px-5"
                    type="submit"
                    @click="logout()"
                >
                    Logout
                </button> -->
                <!-- <button
                    class="btn btn-outline-light btn-lg px-5"
                    type="submit"
                    @click="verifyResend()"
                >
                    Resend
                </button> -->
                <!-- <button
                    class="btn btn-outline-light btn-lg px-5"
                    type="submit"
                    @click="getItems()"
                >
                    Test
                </button> -->
            </span>
            <div
                class="aaa"
                v-show="$store.state.items.add == 'add'"
                style="height: 300px"
            ></div>
            <TodoTools></TodoTools>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import NavbarTodoList from "../components/NavbarTodoList";
import TodoTools from "../components/TodoTools";
export default {
    name: "HomePage",
    components: { NavbarTodoList, TodoTools },
    data() {
        return {
            success: null,
            error: null,
            username: "",
            fetching: false,
        };
    },

    computed: {},

    methods: {
        // ...mapActions("auth", ["sendVerifyResendRequest"]),
        async getItems() {
            let header = {
                headers: {
                    username: this.$store.state.user.userData.username,
                },
            };

            await this.$store.dispatch("items/getItems", header);
            this.$store.commit("items/setDates");
        },

        verifyResend() {
            this.success = this.error = null;
            let header = {
                headers: {
                    path: window.location.hostname,
                },
            };
            this.$store
                .dispatch("user/sendVerifyResendRequest", header)
                .then(() => {
                    this.success =
                        "A fresh verification link has been sent to your email address.";
                    // console.log(
                    //     "A fresh verification link has been sent to your email address."
                    // );
                })
                .catch((error) => {
                    this.error = "Error sending verification link.";
                });
        },

        // async login() {
        //     await this.$store.dispatch("user/sendLoginRequest", {
        //         email: this.email,
        //         password: this.password,
        //     });
        //     this.$router.push({ name: "TestHome" });
        // },
    },
    mounted() {
        // console.log("mount");
        if (localStorage.getItem("authToken")) {
            // console.log("test");
            // console.log(localStorage.getItem("authToken"));
            this.$store
                .dispatch("user/getUserData")
                .then(async (res) => {
                    this.getItems();
                })
                .catch(
                    (err) => {}
                    //  console.log(err)
                );
        } else {
            this.$router.push("/");
        }
    },
    updated() {
        // console.log("->>", this.$store.state.userData);
    },
};
</script>
<style lang="scss">
html,
body,
html * {
    font-family: Poppins !important;
    transition: width 1s;
}
.home-container {
    height: 100vh;
    width: 100%;

    background: linear-gradient(
        90deg,
        hsla(0, 0%, 99%, 1) 0%,
        hsla(0, 0%, 100%, 1) 100%
    );
}
.todo-holder {
    animation: fadeIn 2s;
    display: flex;
    flex-direction: column;
    align-content: center;
    align-items: center;
    flex-grow: 1;
}
.btn {
    width: 200px;
}
.btn + .btn {
    margin-top: 1rem;
}
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}
</style>
