import { createRouter, createWebHistory } from "vue-router";
//admin
import teachingIndex from "../components/teaching/index.vue";
import teachingSub from "../components/teaching/teaching_sub.vue";
import coursesAdmin from "../components/admin/courses/index.vue";
import courses_all_Admin from "../components/admin/courses/courses_all.vue";
import courses_detail_Admin from "../components/admin/courses/courses_detail.vue";
import document_check_Admin from "../components/admin/document_check/index.vue";
import document_check_sub_Admin from "../components/admin/document_check/document_check.vue";
import document_check_detail_Admin from "../components/admin/document_check/document_detail.vue";

import performanceIndex_Admin from "../components/admin/performance_report/index.vue";
import performance_report_Admin from "../components/admin/performance_report/performance_report.vue";
import performance_detail_Admin from "../components/admin/performance_report/performance_detail.vue";
import performance_view_Admin from "../components/admin/performance_report/performance_view.vue";

import DocReportIndex_Admin from "../components/admin/doc_report/index.vue";
import DocReport_Admin from "../components/admin/doc_report/doc_report.vue";
import DocReport_Detail_Admin from "../components/admin/doc_report/doc_report_detail.vue";

import Users_Admin from "../components/admin/users/index.vue";
import User_AddAdmin from "../components/admin/users/add_user.vue";
import User_EditAdmin from "../components/admin/users/edit_user.vue";

//users
import userHome from "../components/users/index.vue";
import userProfile from "../components/users/profile/index.vue";
import userCourseSpec from "../components/users/course_spec/index.vue";
import userSubject_detail from "../components/users/course_spec/subject_detail.vue";
import subdoc from "../components/users/course_spec/subdoc.vue";
import subdoc_sec from "../components/users/course_spec/subdoc_sec.vue";
import userPerformance from "../components/users/performance/index.vue";
import userAddPerformance from "../components/users/performance/add_performance.vue";
import usereditPerformance from "../components/users/performance/edit_performance.vue";
import userPerformanceDetail from "../components/users/performance/performance_detail.vue";
//president
import presidentHome from "../components/president/index.vue";
import presidentDocReport from "../components/president/doc_report/index.vue";
import presidentDocReport_Detail from "../components/president/doc_report/doc_report_detail.vue";
import presidentCourse from "../components/president/course/index.vue";
import presidentCourseDetail from "../components/president/course/course_detail.vue";
import presidentProfile from "../components/president/profile/index.vue";
import presidentTeaching from "../components/president/teaching/index.vue";
import presidentTeachingDetail from "../components/president/teaching/teaching_detail.vue";

import presidentPerformanceReport from "../components/president/performance_report/index.vue";
import presidentPerformanceReportDetail from "../components/president/performance_report/performance_detail.vue";
import presidentPerformanceReportView from "../components/president/performance_report/performance_view.vue";
//manager
import managerHome from "../components/manager/index.vue";
import managerDocReport from "../components/manager/doc_report/index.vue";
import managerDocReport_Detail from "../components/manager/doc_report/doc_report_detail.vue";
import managerPerformanceReport from "../components/manager/performance_report/index.vue";

import notFound from "../components/notFound.vue";

const routes = [
    {
        path: "/admin/teaching",
        component: teachingIndex,
    },
    {
        path: "/admin/teaching/teaching_sub/:id",
        component: teachingSub,
        props: true,
    },
    {
        path: "/admin/courses",
        component: coursesAdmin,
    },
    {
        path: "/admin/courses/courses_all/:id",
        component: courses_all_Admin,
        props: true,
    },
    {
        path: "/admin/courses/course_detail/:id",
        component: courses_detail_Admin,
        props: true,
    },
    {
        path: "/admin/document_check",
        component: document_check_Admin,
    },
    {
        path: "/admin/document_check/document_check_sub/:id",
        component: document_check_sub_Admin,
        props: true,
    },
    {
        path: "/admin/document_check/document_check_detail/:id",
        component: document_check_detail_Admin,
        props: true,
    },
    {
        path: "/admin/performance_report",
        component: performanceIndex_Admin,
    },
    {
        path: "/admin/performance_report/performance_report/:id",
        component: performance_report_Admin,
        props: true,
    },
    {
        path: "/admin/performance_report/performance_report_detail/:id",
        component: performance_detail_Admin,
        props: true,
    },
    {
        path: "/admin/performance_report/performance_view/:id",
        component: performance_view_Admin,
        props: true,
    },
    {
        path:"/admin/users",
        component: Users_Admin
    },
    {
        path:"/admin/users/add_user",
        component: User_AddAdmin
    },
     {
        path:"/admin/users/edit_user/:id",
        component: User_EditAdmin,
        props: true
    },
    //admin_doc_report
    {
        path: "/admin/doc_report",
        component: DocReportIndex_Admin
    },
    {
        path: "/admin/doc_report/doc_report/:id",
        component: DocReport_Admin,
        props: true
    },
    {
        path: "/admin/doc_report/doc_report_detail/:id",
        component: DocReport_Detail_Admin,
        props: true
    },
    // end
    {
        path: "/users/home",
        component: userHome,
    },
    {
        path: "/users/profile",
        component: userProfile,
    },
    {
        path: "/users/course_spec",
        component: userCourseSpec,
    },
    {
        path: "/users/course_spec/subject_detail/:id",
        component: userSubject_detail,
        props: true,
    },
    {
        path: "/users/course_spec/subdoc/:id",
        component: subdoc,
        props: true,
    },
    {
        path: "/users/course_spec/subdoc_sec/:id",
        component: subdoc_sec,
        props: true,
    },
    {
        path: "/users/performance",
        component: userPerformance,
    },
    {
        path: "/users/performance/addperformance",
        component: userAddPerformance,
    },
    {
        path: "/users/performance/performance_detail/:id",
        component: userPerformanceDetail,
        props: true,
    },
    {
        path: "/users/performance/editperformance/:id",
        component: usereditPerformance,
        props: true,
    },
    {
        path: "/:pathMatch(.*)*",
        component: notFound,
    },
    {
        path: "/president/home",
        component: presidentHome,
    },
    {
        path: "/president/doc_report",
        component: presidentDocReport,
    },
    {
        path: "/president/doc_report/doc_report_detail/:id",
        component: presidentDocReport_Detail,
        props: true,
    },
    {
        path: "/president/course",
        component: presidentCourse,
    },
    {
        path: "/president/course/course_detail/:id",
        component: presidentCourseDetail,
        props: true,
    },
    {
        path: "/president/teaching",
        component: presidentTeaching,
    },
    {
        path: "/president/teaching/teaching_detail/:id/:t_id",
        component: presidentTeachingDetail,
        props: true,
    },
    {
        path: "/president/performance_report",
        component: presidentPerformanceReport,
    },
    {
        path: "/president/performance_report/performance_report_detail/:id",
        component: presidentPerformanceReportDetail,
        props: true,
    },
    {
        path: "/president/performance_report/performance_view/:id",
        component: presidentPerformanceReportView,
        props: true,
    },
    {
        path: "/manager/home",
        component: managerHome,
    },
    {
        path: "/manager/doc_report",
        component: managerDocReport,
    },
    {
        path: "/manager/doc_report/doc_report_detail/:id",
        component: managerDocReport_Detail,
        props: true,
    },
    {
        path: "/manager/performance_report",
        component: managerPerformanceReport
    },
];

const router = createRouter({
    // history: createWebHistory(process.env.BASE_URL),
    history: createWebHistory(),
    routes,
});

export default router;
