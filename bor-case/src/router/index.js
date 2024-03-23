import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue';
import AddCarView from "@/views/AddCarView.vue";
import EditCarView from "@/views/EditCarView.vue";
import RegisterView from "@/views/RegisterView.vue";
import CarDetailView from "@/views/CarDetailView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/cars/add',
      name: 'AddCar',
      component: AddCarView,
      meta: { requiresAuth: true }
    },
    {
      path: '/cars/:id/edit',
      name: 'EditCar',
      component: EditCarView,
      meta: { requiresAuth: true }
    },

    {
      path: '/cars/:id',
      name: 'DetailCar',
      component: CarDetailView,
      meta: { requiresAuth: true }
    }
  ]
});

router.beforeEach((to,from,next) => {
  const loggedIn = localStorage.getItem('user_access_token');

  if (to.matched.some(record => record.meta.requiresAuth) && !loggedIn) {
    next('/login');
  } else if ((to.path === '/login' || to.path==='/register') && loggedIn) {
    next('/');
  } else {
    next();
  }
});

export default router
