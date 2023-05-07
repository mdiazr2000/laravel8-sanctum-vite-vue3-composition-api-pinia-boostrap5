<template>
  <div v-if="props.message" class="alert alert-info" role="alert">
    {{ props.message }}
  </div>
</template>

<script setup>
const props = defineProps({
  message: {
    type: String,
    default: "",
  },
});
</script>

<style scoped></style>
