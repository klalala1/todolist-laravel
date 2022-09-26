<template>
    <div></div>
</template>

<script>
export default {
    name: "TodoList",
    props: {
        todoItems: {
            type: [Object, Array, Number],
        },
    },
    mounted() {
        // this.$store.dispatch()
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.red {
    color: red;
}
.green {
    color: green;
}
</style>
