<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
let programs = ref([]);
let teachers = ref({});
let subjectTname = ref({});
let docfile = ref({});
let doc_status = ref({});
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

const get_teachers = async () => {
    try {
        let response = await axios.get(`/api/admin_get_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const get_Subject_teach = async () => {
    try {
        let response = await axios.get(`/api/get_subject_teach/${props.id}`);
        subjectTname.value = response.data.subject;
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const get_doc_status = async (id) => {
    try {
        const dfIds = docfile.value.map(item => item.df_id);
        let response = await axios.get(`/api/admin_get_docfile_status/${dfIds}`);
        doc_status.value = response.data.doc_status;
        console.log('doc_status', doc_status.value);
    } catch (error) {
        console.error('Error fetching doc_status:', error);
    }
};

const getDoc_file = async () => {
    try {
        let response = await axios.get(`/api/admin_get_docfile/${props.id}`);
        docfile.value = response.data.docfile;
        console.log("docfile", docfile.value);
    } catch (error) {
        console.error('Error fetching docfile:', error);
    }
};

const Open_Docfile = () => {
    try {
        const dfIds = docfile.value.map(item => item.df_id);
        window.open(`/api/user_get_docfile_finish/${dfIds}`, '_blank');
    } catch (error) {
        console.error('Error opening docfile:', error);
    }
};
const HomeDoc_report = (id) => {
    router.push('/president/doc_report/');
};

onMounted(async () => {
    await get_teachers();
    await get_Subject_teach();
    await getDoc_file();
    await get_doc_status();
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

        <div class="col-lg-6">
            <div class="card h-100 ">
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
                <div class="card-body p-3 ">

                    <ul class="list-group " v-for="teacher in teachers" :key="teacher.ts_id">
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 border border-bottom"
                            v-for="termTeach in teacher.terms_sub_teach" :key="termTeach.tst_id">
                            <div class="avatar me-3">
                                <div
                                    class="icon icon-shape bg-info-soft shadow text-center border-radius-md shadow-none">
                                    <i class="ni ni-money-coins text-lg text-info text-gradient opacity-10"
                                        aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-start flex-column justify-content-center">
                                <h6 class="mb-0 "> {{ termTeach.users.user_detail.user_d_name }}</h6>
                                <p class="mb-0 text-xs">Hi! I need more information..</p>
                            </div>
                            <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto" href="javascript:;">Reply</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100 ">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0 ">สถานะการจัดทำมคอ. </h5>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-center">
                            <i class="far fa-calendar-alt me-2" aria-hidden="true"></i>
                            <small>23 - 30 March 2021</small>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-2 t">

                    <div class="row mt-2 " v-if="docfile.length == 1">
                        <div class="d-flex">
                            <img class="pdf-icon " src=" /public/assets/img/pdf (9).png" @click="Open_Docfile()">
                        </div>
                    </div>
                    <div class="row" v-if="docfile.length == 0">
                        <div class="col-lg-12">
                            <div class="card bg-light text-center  card-empty-doc">
                                <div class="card-body p-5">
                                    <img class="pdf-icon " src=" /public/assets/img/pdf (9).png">
                                    <p>ยังไม่มีไฟล์เอกสารในขณะนี้</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline timeline-one-side mt-4" v-if="doc_status.length > 0">
                        <div class="timeline-block mb-3" v-for="item in doc_status" :key="item.id">
                            <span class="timeline-step">
                                <i class="ni ni-bell-55 text-success text-gradient"></i>
                            </span>
                            <div class="timeline-content" v-if="item.dfs_status == 0">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">สถานะ : รอตรวจสอบ
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ item.created_at }}</p>
                            </div>
                            <div class="timeline-content" v-if="item.dfs_status == 1">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">สถานะ : เสร็จสิ้น
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ item.created_at }}</p>
                            </div>
                            <div class="timeline-content" v-if="item.dfs_status == 2">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">สถานะ : จัดทำเอกสารใหม่อีกครั้ง
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ item.created_at }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="timeline timeline-one-side mt-4" v-if="doc_status.length == 0">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="ni ni-html5 text-danger text-gradient"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">สถานะ : ยังไม่จัดทำเอกสาร
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">ยังไม่จัดทำเอกสาร มคอ.</p>
                            </div>

                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-5">

                        <button class="btn btn-outline-dark" @click="HomeDoc_report()">กลับหน้าหลัก</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.text-truncate {
    max-width: 80%;
}

.card-empty-doc {
    box-shadow: none !important;
}
</style>
