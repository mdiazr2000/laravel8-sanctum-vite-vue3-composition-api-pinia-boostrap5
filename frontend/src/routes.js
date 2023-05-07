import { createRouter, createWebHistory } from "vue-router";

// setup routes

const routes = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      name: "Login",
      component: () => import("./views/login/LoginUser.vue"),
      meta: { middleware: "guest" },
    },
    {
      path: "/register",
      name: "Register",
      component: () => import("./views/register/RegisterClient.vue"),
      meta: { middleware: "guest" },
    },
    {
      path: "/",
      name: "layout",
      component: import("./components/LayoutRoot.vue"),
      children: [
        {
          path: "/dashboard",
          name: "Dashboard",
          component: () => import("./views/dashboard/DashboardGeneral.vue"),
          meta: { middleware: "admin" },
        },
        {
          path: "/",
          name: "Client",
          component: () => import("./components/LayoutClient.vue"),
          meta: { middleware: "admin" },
          children: [
            {
              path: "/client/availableBooks",
              name: "AvailableBooks",
              component: () => import("./views/client/booksList/BooksList.vue"),
              meta: { middleware: "admin" },
            },
            {
              path: "/client/reservedBooks",
              name: "ReservedBooks",
              component: () =>
                import("./views/client/reservationList/ReservationsList.vue"),
              meta: { middleware: "admin" },
            },
          ],
        },
        {
          path: "/",
          name: "Worker",
          component: () => import("./components/LayoutWorker.vue"),
          meta: { middleware: "admin" },
          children: [
            {
              path: "/worker/listBooks",
              name: "ListBooks",
              component: () => import("./views/worker/booksList/BooksList.vue"),
              meta: { middleware: "admin" },
            },
          ],
        },
      ],
    },
  ],
});

export default routes;
