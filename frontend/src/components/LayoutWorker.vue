<template>
  <div>
    <h5>General Info for Worker</h5>
    <h6>Name: {{ store.profile.name }}</h6>
  </div>
  <router-view></router-view>
</template>

<script setup>
import { useAuthStore } from "../stores.js";
const store = useAuthStore();
</script>

<style scoped></style>
