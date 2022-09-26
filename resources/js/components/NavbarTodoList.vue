<template>
    <div>
        <b-navbar toggleable="lg" type="light" variant="info" fixed="top">
            <b-navbar-brand href="#" style="color: black; font-weight: 700"
                >TodoList</b-navbar-brand
            >

            <b-navbar-toggle
                target="nav-collapse"
                style="color: black"
            ></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <!-- <b-navbar-nav>
                    <b-nav-item href="#">Link</b-nav-item>
                    <b-nav-item href="#" disabled>Disabled</b-nav-item>
                </b-navbar-nav> -->

                <!-- Right aligned nav items -->
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right style="z-index: 100000000000">
                        <!-- Using 'button-content' slot -->

                        <!-- <b-dropdown-item @click="completed()"
                            >Completed Todo</b-dropdown-item
                        > -->
                        <Completed />
                        <b-dropdown-item @click="logout()"
                            >Sign Out</b-dropdown-item
                        >
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse>
        </b-navbar>
    </div>
</template>

<script>
import Completed from "./Completed.vue";
export default {
    name: "NavbarTodoList",
    components: { Completed },
    methods: {
        async logout() {
            this.$store.dispatch("user/sendLogoutRequest").then((res) => {
                // console.log("toooo");
                // this.$router.push({ name: "LandingPage" });
                this.$router.push("/");
            });
        },
        completed() {
            this.$router.push("/completed");
        },
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped></style>
