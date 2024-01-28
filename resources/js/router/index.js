import { createRouter,createWebHistory } from 'vue-router'

import teachingIndex from '../components/teaching/index.vue'
import notFound from '../components/teaching/index.vue'

const routes = [
    {
        path : '/admin/teaching',
        component : teachingIndex
    },
    {
        path : '/:pathMatch(.*)*',
        component : notFound
    }
]

const router  = createRouter({
    // history: createWebHistory(process.env.BASE_URL),
    history: createWebHistory(),
    routes,
})

export default router
