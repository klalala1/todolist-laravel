<template>
    <div class="landing-container">
        <NavbarHomePage></NavbarHomePage>
        <!-- v-b-modal.modal-1 -->
        <HomeCaligraph></HomeCaligraph>

        <b-button
            pill
            style="
                background: linear-gradient(
                    34deg,
                    rgba(2, 0, 36, 1) 0%,
                    rgba(121, 75, 9, 1) 0%,
                    rgba(67, 41, 21, 1) 40%,
                    rgba(0, 0, 0, 1) 100%
                );
            "
            @click="openModal()"
            >Get Started</b-button
        >
        <b-nav></b-nav>

        <b-modal
            id="modal-get-started"
            hide-footer
            hide-header
            content-class="modal-content-transparent"
        >
            <LoginBox
                v-show="this.$store.state.user.homeModal !== 'register'"
            />
            <RegisterBox
                v-show="this.$store.state.user.homeModal === 'register'"
            />
        </b-modal>

        <router-view></router-view>
    </div>
</template>

<script>
import LoginBox from "../components/LoginBox";
import NavbarHomePage from "../components/NavbarHomePage";
import RegisterBox from "../components/RegisterBox";
import { mapState } from "vuex";
import HomeCaligraph from "../components/HomeCaligraph";
export default {
    name: "LandingPage",
    components: { LoginBox, NavbarHomePage, RegisterBox, HomeCaligraph },
    data() {
        return {
            user: this.$store.state.userData,
            email: null,
            password: null,
        };
    },
    computed: {
        ...mapState(["homeModal"]),
    },
    mounted() {
        console.log("mountedd trying auth");
        // try {
        //     this.authUser();
        // } catch (error) {
        //     console.log(error);
        // }
        if (localStorage.getItem("authToken")) {
            this.$store.dispatch("user/getUserData", header).then((res) => {
                this.$router.push("/HomePage");
            });
        }
    },
    methods: {
        openModal() {
            this.$root.$emit("bv::show::modal", "modal-get-started");
        },
    },

    updated() {},
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.modal-content-transparent {
    background-color: transparent !important;
    border: none !important;
}
</style>
<style scoped>
.landing-container {
    width: 100vw;
    height: 100vh;
    background-color: blanchedalmond;
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    flex-direction: column;
}
.btn {
    background: linear-gradient(
        34deg,
        rgba(2, 0, 36, 1) 0%,
        rgba(121, 75, 9, 1) 0%,
        rgba(67, 41, 21, 1) 40%,
        rgba(0, 0, 0, 1) 100%
    ) !important;
    border: none !important;
}
</style>
