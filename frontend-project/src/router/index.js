import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "dashboard",
      meta: { title: "Dashboard" },
      component: () => import("../views/Dashboard/Index.vue"),
    },
  ],
});

router.beforeEach((to, form, next) => {
  document.title = to.meta.title;
  next();
});

export default router;
