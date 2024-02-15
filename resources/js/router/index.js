import { createRouter,createWebHistory } from 'vue-router'
//admin
import teachingIndex from '../components/teaching/index.vue'
import teachingSub from '../components/teaching/teaching_sub.vue'
import coursesAdmin from '../components/admin/courses/index.vue'
import courses_all_Admin from '../components/admin/courses/courses_all.vue'
import courses_detail_Admin from '../components/admin/courses/courses_detail.vue'
//users
import userHome from '../components/users/index.vue'
import userProfile from '../components/users/profile/index.vue'
import userCourseSpec from '../components/users/course_spec/index.vue'
import userSubject_detail from '../components/users/course_spec/subject_detail.vue'
import subdoc_fisrt from '../components/users/course_spec/subdoc_first.vue'
import subdoc_sec from '../components/users/course_spec/subdoc_sec.vue'
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
        path : '/admin/courses',
        component : coursesAdmin,
    },
    {
        path : '/admin/courses/courses_all/:id',
        component : courses_all_Admin,
        props : true
    },
    {
        path : '/admin/courses/course_detail/:id',
        component : courses_detail_Admin,
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
        path : '/users/course_spec/subject_detail/:id',
        component : userSubject_detail,
        props : true
    },
    {
        path : '/users/course_spec/subdoc_first/:id',
        component : subdoc_fisrt,
        props : true
    },
    {
        path : '/users/course_spec/subdoc_sec/:id',
        component : subdoc_sec,
        props : true
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
