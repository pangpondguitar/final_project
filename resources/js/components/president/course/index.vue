<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
let user = ref({});
let program = ref("");
let course = ref({});
let teacher_count = ref('');

const userId = document.getElementById('app').getAttribute('data-user-id');
let User_pId = ref('')
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_UserProgram = async () => {
    try {
        let response = await axios.get(`/api/president_get_user_data/${userId}`);
        user.value = response.data.user;
        User_pId.value = user.value.p_id
    } catch (error) {
        console.error("Error fetching user:", error);
    }
};

const get_Program = async () => {
    try {
        let response = await axios.get(`/api/president_get_program/${User_pId.value}`);
        program.value = response.data.program;
        course.value = response.data.course;
        teacher_count.value = response.data.teacher_count;
        console.log('program', program.value);
    } catch (error) {
        console.error("Error fetching program:", error);
    }
};
// const get_Terms = async () => {
//     try {
//         let response = await axios.get(`/api/get_all_terms`);
//         terms.value = response.data.terms;
//         currentTerm.value = terms.value[0].t_id;
//     } catch (error) {
//         console.error("Error fetching terms:", error);
//     }
// };

// const getSubject = async (page = 1) => {
//     try {
//         let response = await axios.get(`/api/president_get_subjectAll_term/${User_pId.value}/${currentTerm.value}/?page=${page}`);
//         subjects.value = response.data.subjects;
//         console.log('subjects', subjects.value);
//     } catch (error) {
//         console.error('Error fetching subjects:', error);
//     }
// };

// const term = async (event) => {
//     const t_id = event.target.value;
//     console.log(event.target.value);
//     currentTerm.value = t_id;
//     await getSubject();
// };
// const statusDocCheck = (status) => {
//     const doc_status = status;

// }
const Course_detail = (id) => {
    router.push('/president/course/course_detail/' + id);
};

onMounted(async () => {
    await get_UserProgram();
    await get_Program();
});
</script>

<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 ">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0 "> หลักสูตรทั้งหมด</h5>
                            <h4 class="fw-normal text-muted h6">หลักสูตรทั้งหมด</h4>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-xl-5  col-lg-6 text-center">
                            <img class="w-100 border-radius-lg shadow-lg mx-auto"
                                src=" /public/assets/img/education.jpeg" alt="chair">
                        </div>
                        <div class="col-lg-5 col-lg-6 mx-auto  border-radius-lg">
                            <h4 class="mt-lg-0 ">{{ program.p_name }}</h4>
                            <div class="rating">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                            </div>
                            <br>
                            <label class="mt-0 ms-0 ">อาจารย์ภายในสาขา</label>
                            <h4>{{ teacher_count }}</h4>
                            <span class="badge bg-gradient-success">จำนวน (ทั้งหมด)</span>
                            <hr>

                            <label class="mt-0">Description</label>
                            <ul>
                                <li>{{ program.p_name }}</li>
                                <li>{{ program.p_detail }}</li>

                            </ul>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body pt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0 "> หลักสูตรทั้งหมด</h5>
                            <h4 class="fw-normal text-muted h6">หลักสูตรทั้งหมด</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 " v-for="item in course" :key="item.id">
                            <div class="card mt-2">
                                <img class="card-img-top"
                                    src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1651&amp;q=80">
                                <div class="position-relative"
                                    style="height: 50px;overflow: hidden;margin-top: -50px;z-index:2;position: relative;">
                                    <div class="position-absolute w-100 top-0" style="z-index: 1;">
                                        <svg class="waves waves-sm" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 40"
                                            preserveAspectRatio="none" shape-rendering="auto">
                                            <defs>
                                                <path id="card-wave"
                                                    d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
                                                </path>
                                            </defs>
                                            <g class="moving-waves">
                                                <use xlink:href="#card-wave" x="48" y="-1" fill="rgba(255,255,255,0.30">
                                                </use>
                                                <use xlink:href="#card-wave" x="48" y="3" fill="rgba(255,255,255,0.35)">
                                                </use>
                                                <use xlink:href="#card-wave" x="48" y="5" fill="rgba(255,255,255,0.25)">
                                                </use>
                                                <use xlink:href="#card-wave" x="48" y="8" fill="rgba(255,255,255,0.20)">
                                                </use>
                                                <use xlink:href="#card-wave" x="48" y="13"
                                                    fill="rgba(255,255,255,0.15)"></use>
                                                <use xlink:href="#card-wave" x="48" y="16"
                                                    fill="rgba(255,255,255,0.99)"></use>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="mb-0">{{ item.c_name }}</h5>
                                    <small class="text-muted">{{ item.c_name2 }}</small>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div>
                                            <a class="text-primary icon-move-right"
                                                @click="Course_detail(item.c_id)">ไปยังหลักสูตร
                                                <i class="fas fa-arrow-right text-xs ms-1" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
