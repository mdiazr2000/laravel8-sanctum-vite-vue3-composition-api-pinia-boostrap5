<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <router-link to="/dashboard" style="text-decoration: none">
        <a class="navbar-brand" href="#">Library</a>
      </router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navbarNavAltMarkup" class="collapse navbar-collapse">
        <!-- Links available to client -->
        <router-link
          v-if="
            isClient && !!store.permissions.find((item) => item == 'see_book')
          "
          to="/client/availableBooks"
          style="text-decoration: none; color: black"
        >
          <a class="nav-link active" aria-current="page"> Books List </a>
        </router-link>
        <router-link
          v-if="
            isClient &&
            !!store.permissions.find((item) => item == 'see_reservation')
          "
          to="/client/reservedBooks"
          style="text-decoration: none; color: black; padding-left: 20px"
        >
          <a class="nav-link active" aria-current="page"> Books Reserved </a>
        </router-link>
        <div v-if="isWorker" class="navbar-nav">
          <router-link
            v-if="
              isWorker &&
              !!store.permissions.find((item) => item == 'list_book')
            "
            to="/worker/listBooks"
            style="text-decoration: none; color: black"
          >
            <a class="nav-link active" aria-current="page"> Books List </a>
          </router-link>
        </div>
        <a
          v-if="store.token !== ''"
          class="nav-link"
          style="cursor: pointer; padding-left: 20px"
          @click="logout"
          >Logout</a
        >
      </div>
    </div>
  </nav>
  <router-view></router-view>
</template>

<script setup>
import { useAuthStore } from "../stores.js";
import { useRouter } from "vue-router";
import { computed } from "vue";

const router = useRouter();

const store = useAuthStore();

const logout = () => {
  store.cleanToken();
  store.cleanPermissions();
  store.cleanRoles();
  store.cleanProfile();
  router.push({ name: "Login" });
};

const isClient = computed(() => {
  return !!store.roles.find((role) => role == "client");
});

const isWorker = computed(() => {
  return !!store.roles.find((role) => role == "worker");
});
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
