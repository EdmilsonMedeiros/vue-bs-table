import { createRouter, createWebHistory } from 'vue-router'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      meta: { title: 'Home' },
      component: () => import('../views/HomeView.vue')
    },
    {
      path: '/about',
      name: 'about',
      meta: { title: 'Home' },
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/login',
      name: 'login',
      meta: { title: 'Home' },
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      meta: { title: 'Register' },
      component: () => import('../views/RegisterView.vue')
    },
    {
      path: '/user/dashboard',
      name: 'dashboard',
      meta: { title: 'Dashboard' },
      component: () => import('../views/Dashboard/Index.vue')
    },
  ]
})

router.beforeEach((to, form, next) => {
  document.title = to.meta.title;
  next();
});

export default router
