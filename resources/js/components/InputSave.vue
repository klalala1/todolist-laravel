<template>
  <span
    ><input v-model="text" type="text" />
    <button @click="save()">{{ `SAVE` }}</button></span
  >
</template>

<script>
export default {
  name: 'InputSave',
  data() {
    return { text: '' }
  },
  methods: {
    save() {
      this.$emit('save', this.text)
    },
  },
}
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
