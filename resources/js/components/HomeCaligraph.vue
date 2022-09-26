<template>
    <div>
        <h1>Welcome to TodoList</h1>

        <svg class="wave-top" width="100" viewBox="0 0 1200 250">
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M0 108.306L50 114.323C100 120.34 200 132.374 300 168.476C400 204.578 500 264.749 600 246.698C700 228.647 800 132.374 900 108.306C1000 84.2382 1100 132.374 1150 156.442L1200 180.51V-8.5451e-06H1150C1100 -8.5451e-06 1000 -8.5451e-06 900 -8.5451e-06C800 -8.5451e-06 700 -8.5451e-06 600 -8.5451e-06C500 -8.5451e-06 400 -8.5451e-06 300 -8.5451e-06C200 -8.5451e-06 100 -8.5451e-06 50 -8.5451e-06H0V108.306Z"
                fill="#0099FF"
            />
        </svg>
    </div>
</template>

<script>
import { translate } from "./animate";
export default {
    name: "HomeCaligraph",
    mounted() {
        translate(this.$refs.square);
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
body {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: darkblue;
    text-align: center;
    color: white;
    box-sizing: border-box;
    padding: 1rem;
}

h1 {
    position: relative;
    z-index: 10;
}

a {
    color: #ffe37b;
    text-decoration: none;
}

.wave-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
}
</style>
