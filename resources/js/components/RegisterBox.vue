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
                                Register
                            </h2>
                            <p style="margin-bottom: 5rem; color: white">
                                Please enter your information to sign up
                            </p>
                            <form
                                @submit="register()"
                                @keyup.enter="register()"
                            >
                                <b-form class="form-outline form-white mb-4">
                                    <input
                                        type="username"
                                        id="typeUsernameX"
                                        class="form-control form-control-lg"
                                        placeholder="username"
                                        v-model="username"
                                        required
                                    />
                                </b-form>

                                <b-form class="form-outline form-white mb-4">
                                    <input
                                        type="email"
                                        id="typeEmailX"
                                        class="form-control form-control-lg"
                                        placeholder="Email"
                                        v-model="email"
                                        required
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
                                        required
                                    />
                                </b-form>

                                <b-form class="form-outline form-white mb-4">
                                    <input
                                        onkeypress="return event.keyCode != 13;"
                                        type="Password"
                                        id="typeRepeatPasswordX"
                                        class="form-control form-control-lg"
                                        placeholder="Password (Again)"
                                        v-model="repeatPassword"
                                        required
                                    />
                                </b-form>
                            </form>
                            <b-button
                                class="btn btn-outline-light btn-lg px-5"
                                type="submit"
                                style="background-color: transparent"
                                @click="register()"
                            >
                                Sign Up
                            </b-button>

                            <div
                                class="d-flex justify-content-center text-center mt-4 pt-1"
                            >
                                <a href="#!" class="text-white"
                                    ><i class="fab fa-google fa-lg"></i
                                ></a>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0" style="color: white">
                                Already have an account?
                                <button
                                    class="text-white-50 fw-bold"
                                    @click="changeModal()"
                                    style="
                                        background-color: transparent;
                                        border: none;
                                    "
                                >
                                    Sign In
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
    name: "RegisterBox",
    methods: {
        changeModal() {
            this.$store.commit("user/changeHomeModal");
        },
        test() {
            axios.post();
        },
        changeModal() {
            this.$store.commit("user/changeHomeModal");
        },
        fetchItems() {
            this.$store.dispatch("user/getItems").then((a) => {});
        },
        async register() {
            let usera = {
                username: this.username,
                email: this.email,
                password: this.password,
            };
            //    console.log(usera);
            await this.$store
                .dispatch("user/registerUser", usera)
                .then((res) => {
                    this.$router.push("/HomePage");
                })
                .catch((err) => {
                    this.$store.commit(
                        "user/setError",
                        err.response.data.errors
                    );
                });
        },
    },

    data() {
        return {
            username: null,
            email: null,
            password: null,
            repeatPassword: null,
        };
    },
    updated() {},
    async mounted() {
        this.$store.commit("user/resetError");
        // this.fetchItems();
    },
    watch: {
        // repeatPassword() {
        //     console.log("old => ", oldVal, "new => ", newVal);
        // },
        // password() {
        //     console.log("old => ", oldVal, "new => ", newVal);
        // },
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
