import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
  state: () => ({ token: null, permissions: [], roles: [], profile: {} }),
  actions: {
    cleanToken() {
      this.token = null;
    },
    cleanPermissions() {
      this.permissions = [];
    },
    cleanRoles() {
      this.roles = [];
    },
    cleanProfile() {
      this.profile = {};
    },
  },
  persist: true,
});
