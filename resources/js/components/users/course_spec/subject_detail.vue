
<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();

let subjectTname = ref({
});
let teachers = ref({
});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_Subject_teach = async () => {
    try {
        let response = await axios.get(`/api/get_subject_teach/${props.id}`);
        subjectTname.value = response.data.subject;
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};

const get_teachers = async () => {
    try {
        let response = await axios.get(`/api/get_teachers/29`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const Subdoc_fisrt = (id) => {
    router.push('/users/course_spec/subdoc_first/' + id);
};
onMounted(async () => {
    await get_Subject_teach();
    await get_teachers();
});
</script>

<template>
    <div class="row">
        <div v-for="subject in subjectTname" :key="subject.ts_id">
            <h4 class="mb-0"> {{ subject.subjects.s_name }}</h4>

            <h4 class="fw-normal text-muted h6">รายวิชา{{ subject.subjects.s_name }}</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-4">
            <!-- <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-2">จัดทำ มคอ.</h4>
                </div>

            </div> -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card" @click="Subdoc_fisrt(props.id)">
                        <div class="card-body">
                            <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                <i class="ni ni-curved-next opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="mt-3 mb-0">มคอ.3 <span class="text-secondary text-sm">m</span></h5>
                            <p class="mb-0">จัดทำ มคอ3</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center">
                                <i class="ni ni-curved-next opacity-10" aria-hidden="true"></i>
                            </div>
                            <h5 class="mt-3 mb-0">มคอ.4 <span class="text-secondary text-sm">m</span></h5>
                            <p class="mb-0">จัดทำ มคอ4</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="card card-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-2     ">สถานะการจัดทำ มคอ.</h5>
                                        </div>
                                        <div>
                                            <span class="badge badge-success">ตรวจสอบแล้ว</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="timeline timeline-one-side mt-2">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="ni ni-bell-55 text-success text-gradient"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="ni ni-html5 text-danger text-gradient"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="ni ni-cart text-info text-gradient"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="ni ni-credit-card text-warning text-gradient"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order
                                            #4395133</h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i class="ni ni-key-25 text-primary text-gradient"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development
                                        </h6>
                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card ">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 ">อาจารย์ผู้สอน</h5>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                            <small>23 - 30 March 2021</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">

                    <ul class="list-group " v-for="teacher in teachers" :key="teacher.ts_id">
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 border border-bottom"
                            v-for="termTeach in teacher.terms_sub_teach" :key="termTeach.tst_id">
                            <div class="avatar me-3">
                                <div class="icon icon-shape bg-info-soft shadow text-center border-radius-md shadow-none">
                                    <i class="ni ni-money-coins text-lg text-info text-gradient opacity-10"
                                        aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-start flex-column justify-content-center">
                                <h5 class="mb-0 "> {{ termTeach.users.user_detail.user_d_name }}</h5>
                                <p class="mb-0 text-xs">Hi! I need more information..</p>
                            </div>
                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-4 ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-2     ">ไฟล์เอกสาร มคอ.</h5>
                                </div>
                                <div>
                                    <span class="badge badge-danger">pdf</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>

    </div>
</template>
<style>
.text-truncate {
    max-width: 80%;
}

.select-year {
    width: 240px;
    font-size: 16px;
}

.card-2 {
    height: 400px !important;
}
</style>


