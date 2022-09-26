<template>
    <div id="app">
        <!-- <img alt="Vue logo" /> -->

        <LoginPage text="testettet" />
        <li><router-link class="items" to="/test">test</router-link></li>

        <!-- <router-view></router-view> -->
    </div>
</template>

<script>
export default {
    name: "App",
    components: {},
};
</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}
</style>
