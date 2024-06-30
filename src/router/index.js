import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/HomeView.vue';
import Login from '../components/LoginView.vue';
import Signup from '../components/SignupView.vue';
import ProgressTracker from '../components/ProgressTrackerView.vue';
import Blog from '../components/BlogView.vue';
import BlogAdmin from '../components/BlogAdminView.vue';
//PMS-Fit/src/components/BlogAdminView.vue
//PMS-Fit/src/components/HomeView.vue
//PMS-Fit/src/router/index.js
//PMS-Fit/src/components/HomeView.vue
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/signup',
      name: 'signup',
      component: Signup
    },
    {
      path: '/progress-tracker',
      name: 'progress-tracker',
      component: ProgressTracker
    },
    {
      path: '/blog',
      name: 'blog',
      component: Blog
    },
    {
      path: '/blog-admin',
      name: 'blog-admin',
      component: BlogAdmin
    }
    // {
    //   path: '/:catchAll(.*)',
    //   name: 'NotFound',
    //   // component: NotFound TODO: Create a 404 page
    // }
  ]
})

export default router
