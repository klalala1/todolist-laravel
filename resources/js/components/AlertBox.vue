<template>
    <div class="alert">
        <slot name="header"></slot> <slot name="text"></slot>
    </div>
</template>

<script>
export default {
    name: "AlertBox",
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.alert {
    border: 2px solid red;
    padding: 10px;
}
</style>
