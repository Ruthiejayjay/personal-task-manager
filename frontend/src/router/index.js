import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TaskView from '../views/tasks/TaskView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/RegisterView.vue')
    },
    {
      path: '/tasks/create',
      name: 'create',
      component: () => import('../views/tasks/CreateTask.vue')
    },
    {
      path: '/tasks/:id/edit',
      name: 'update',
      component: () => import('../views/tasks/UpdateTask.vue')
    },
    {
      path: '/tasks/:id',
      name: 'task',
      component: TaskView
    }
  ]
})

export default router
