<template>
  <div
    style="
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 100px;
    "
  >
    <ErrorContainer :errors="data.validationErrors" />
    <div
      style="
        display: flex;
        width: 400px;
        flex-direction: column;
        justify-content: space-around;
      "
    >
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email</label>
        <input
          id="exampleFormControlInput1"
          type="email"
          class="form-control"
          placeholder="name@example.com"
          :value="data.email"
          @input="(event) => (data.email = event.target.value)"
        />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput2" class="form-label"
          >Password</label
        >
        <input
          id="exampleFormControlInput2"
          type="password"
          class="form-control"
          placeholder="name@example.com"
          :value="data.password"
          @input="(event) => (data.password = event.target.value)"
        />
      </div>
      <button type="button" class="btn btn-primary" @click="login">
        Login
      </button>
      <div style="padding: 20px">
        Dont you have an account
        <router-link to="/register">Register</router-link>
      </div>
    </div>
  </div>
</template>
<script setup>
import "./login.scss";
import { getLoginEndpoint } from "../../core/endpoints";
import { reactive } from "vue";
import ErrorContainer from "../../components/ErrorContainer.vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "../../stores.js";
import axios from "axios";

const router = useRouter();
const store = useAuthStore();

const data = reactive({
  email: "",
  password: "",
  processing: false,
  validationErrors: [],
});

const login = () => {
  axios
    .post(getLoginEndpoint, {
      email: data.email,
      password: data.password,
    })
    .then((response) => {
      store.token = response.data.token;
      store.permissions = response.data.permissions;
      store.roles = response.data.roles;
      store.profile = response.data.profileInfo;
      router.push("/dashboard");
    })
    .catch((error) => {
      const status = error.response.status;
      let objResponse = {};
      objResponse = {
        data: {
          error: error.response.data,
        },
        status: status,
      };
      data.validationErrors = objResponse.data.error;
    });
};
</script>
<style scoped lang="scss"></style>
