<template>
    <b-container style="max-width: 500px">
        <b-row
            style="
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            "
        >
            <b-col cols="12" col-md="8" col-lg="6" col-xl="5">
                <b-card
                    text="white"
                    style="border-radius: 1rem; background-color: #332d2d"
                >
                    <b-card-body p="5" text="center">
                        <div mb="5" md="5" mt="4" pb="5">
                            <h2
                                fw="bold"
                                mb="2"
                                text="uppercase"
                                style="color: white"
                            >
                                Sign In
                            </h2>
                            <p style="margin-bottom: 5rem; color: white">
                                Please enter your login and password
                            </p>
                            <form @submit="login()" @keyup.enter="login()">
                                <b-form class="form-outline form-white mb-4">
                                    <input
                                        onkeypress="return event.keyCode != 13;"
                                        type="email"
                                        id="typeEmailX"
                                        class="form-control form-control-lg"
                                        placeholder="Email"
                                        v-model="email"
                                    />
                                </b-form>

                                <b-form class="form-outline form-white mb-4">
                                    <input
                                        onkeypress="return event.keyCode != 13;"
                                        type="password"
                                        id="typePasswordX"
                                        class="form-control form-control-lg"
                                        placeholder="Password"
                                        v-model="password"
                                    />
                                </b-form>
                                <b-form-checkbox
                                    id="checkbox-1"
                                    name="checkbox-1"
                                    value="accepted"
                                    unchecked-value="not_accepted"
                                    style="color: white; padding-bottom: 1rem"
                                    disabled
                                >
                                    Remember me
                                </b-form-checkbox>
                            </form>
                            <p class="small mb-5 pb-lg-2">
                                <button
                                    class="text-white-50"
                                    @click="changeModal()"
                                    style="
                                        background: transparent;
                                        color: transparent;
                                        border: none;
                                    "
                                >
                                    Forgot password? Register a new account!
                                </button>
                            </p>
                            <button
                                class="btn btn-outline-light btn-lg px-5"
                                type="submit"
                                @click="login()"
                            >
                                Login
                            </button>

                            <div
                                class="d-flex justify-content-center text-center mt-4 pt-1"
                            ></div>
                        </div>
                        <div>
                            <p class="mb-0" style="color: white">
                                Don't have an account?
                                <button
                                    class="text-white-50 fw-bold"
                                    @click="changeModal()"
                                    style="
                                        background-color: transparent;
                                        border: none;
                                    "
                                >
                                    Sign Up
                                </button>
                            </p>
                        </div>
                    </b-card-body>
                </b-card>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import { mapMutations } from "vuex";
export default {
    name: "LoginBox",
    data() {
        return {
            email: null,
            password: null,
        };
    },
    methods: {
        signUp() {
            $this.state.modal;
        },
        changeModal() {
            this.$store.commit("user/changeHomeModal");
        },
        // fetchItems() {
        //     this.$store.dispatch("user/getItems").then((a) => {});
        // },
        async login() {
            this.$store.commit("user/resetError");
            await this.$store
                .dispatch("user/sendLoginRequest", {
                    email: this.email,
                    password: this.password,
                })
                .then(async (res) => {
                    console.log(res);
                    await this.$router.push("/HomePage");
                })
                .catch((err) => {
                    this.$store.commit(
                        "user/setError",
                        err.response.data.errors
                    );
                });
        },
    },
    async mounted() {
        this.$store.commit("user/resetError");
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
