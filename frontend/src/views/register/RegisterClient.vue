<template>
  <div
    style="
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: 100px;
    "
  >
    <router-link to="/">Back to Login</router-link>
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
        <label for="exampleFormControlInput1" class="form-label">Name</label>
        <input
          id="exampleFormControlInput1"
          type="text"
          class="form-control"
          placeholder="First name"
          :value="data.name"
          @input="(event) => (data.name = event.target.value)"
        />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label"
          >Last Name</label
        >
        <input
          id="exampleFormControlInput1"
          type="text"
          class="form-control"
          placeholder="Last name"
          :value="data.lastname"
          @input="(event) => (data.lastname = event.target.value)"
        />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">CI</label>
        <input
          id="exampleFormControlInput1"
          type="text"
          class="form-control"
          placeholder="CI"
          :value="data.ci"
          @input="(event) => (data.ci = event.target.value)"
        />
      </div>
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
          placeholder="password"
          :value="data.password"
          @input="(event) => (data.password = event.target.value)"
        />
      </div>
      <button type="button" class="btn btn-primary" @click="register">
        Register
      </button>
    </div>
  </div>
</template>

<script setup>
import { getRegisterEndpoint } from "../../core/endpoints";
import { reactive, onMounted } from "vue";
import ErrorContainer from "../../components/ErrorContainer.vue";
import { PostWithoutTokenRequest } from "../../core/api-request";
import { useRouter } from "vue-router";

const router = useRouter();

const data = reactive({
  name: "",
  lastname: "",
  ci: "",
  email: "",
  password: "",
  validationErrors: [],
});

const register = async () => {
  const url = getRegisterEndpoint;

  data.validationErrors = null;
  const result = await PostWithoutTokenRequest(url, {
    name: data.name,
    lastname: data.lastname,
    ci: data.ci,
    email: data.email,
    password: data.password,
  });
  if (result.status !== 200) {
    data.validationErrors = result.data.error;
  } else {
    router.push("/");
  }
};

onMounted(() => {
  data.email = "";
  data.password = "";
  data.name = "";
  data.lastname = "";
  data.ci = "";
});
</script>

<style scoped>
.alert .alert-danger {
  height: auto;
}
</style>
