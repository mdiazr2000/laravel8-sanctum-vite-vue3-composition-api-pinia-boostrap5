<template>
  <div>
    Welcome to your admin view
    <span style="font-size: 24px; color: #d95644">{{
      store.roles.join(",")
    }}</span>
  </div>
</template>

<script setup>
import { useAuthStore } from "../../stores.js";

const store = useAuthStore();
</script>

<style scoped>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 0px;
}
</style>
