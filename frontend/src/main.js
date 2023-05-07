import { createApp } from "vue";
import App from "./App.vue";
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import { createPinia } from "pinia";
import piniaPluginPersistedState from "pinia-plugin-persistedstate";

import routes from "./routes.js";

const pinia = createPinia();
pinia.use(piniaPluginPersistedState);

const app = createApp(App);

// tell Vue to use router
app.use(pinia);
app.use(routes);
app.mount("#app");

import "bootstrap/dist/js/bootstrap.js";

import { useAuthStore } from "./stores.js";

const store = useAuthStore();

routes.beforeEach((to, from, next) => {
  if (to.meta.middleware == "guest") {
    if (store.token) {
      next();
    }
  } else {
    if (store.token) {
      next();
    } else {
      next({ name: "Login" });
    }
  }
  next();
});
