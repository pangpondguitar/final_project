import { createRouter,createWebHistory } from 'vue-router'

import teachingIndex from '../components/teaching/index.vue'
import teachingSub from '../components/teaching/teaching_sub.vue'
import userHome from '../components/users/index.vue'
import userProfile from '../components/users/profile/index.vue'
import userCourseSpec from '../components/users/course_spec/index.vue'

import notFound from '../components/notFound.vue'

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
        path : '/users/home',
        component : userHome
    },
    {
        path : '/users/profile',
        component : userProfile
    },
    {
        path : '/users/course_spec',
        component : userCourseSpec
    },
    {
        path : '/:pathMatch(.*)*',
        component : notFound
    },

]

const router  = createRouter({
    // history: createWebHistory(process.env.BASE_URL),
    history: createWebHistory(),
    routes,
})

export default router
