import { createRouter,createWebHistory } from 'vue-router'

import teachingIndex from '../components/teaching/index.vue'
import teachingSub from '../components/teaching/teaching_sub.vue'
import notFound from '../components/teaching/index.vue'

const routes = [
    {
        path : '/admin/teaching',
        component : teachingIndex
    },
       {
        path : '/admin/teaching/teaching_sub/:id',
        component : teachingSub,
        props : true
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
