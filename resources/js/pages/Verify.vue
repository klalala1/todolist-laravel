<template>
    <div class="verify">
        <div class="alert alert-danger" role="alert" v-if="error">
            {{ error }}
        </div>
        <h1 v-show="!error">Please wait..</h1>
    </div>
</template>

<script>
export default {
    name: "Verify",
    props: ["hash"],

    data() {
        return {
            error: null,
        };
    },

    async mounted() {
        let data = {
            hash: this.hash,
        };

        await this.$store
            .dispatch("user/sendVerifyRequest", data)
            .then((res) => {
                this.$router.push({ path: "/", params: {} });
            })
            .catch((error) => {
                // console.log(error.response);
                this.error = "Error verifying email";
            });
    },

    computed: {},

    methods: {},
};
</script>
