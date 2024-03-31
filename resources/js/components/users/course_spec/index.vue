<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();

let programs = ref([]);
let terms = ref({});
let currentTerm = ref("");
let subjects = ref("");
let selectedTerm = ref("");
const userId = document.getElementById('app').getAttribute('data-user-id');

const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        currentTerm.value = terms.value[0].t_id;
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};

const getSubject = async () => {
    try {
        let response = await axios.get(`/api/get_all_subject/${userId}/${currentTerm.value}`);
        subjects.value = response.data.subjects;
        console.log('subjects', subjects.value);
    } catch (error) {
        console.error('Error fetching subjects:', error);
    }
};

const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await getSubject();
};
const subjects_detail = (id) => {
    router.push('/users/course_spec/subject_detail/' + id);
};

onMounted(async () => {
    await get_Terms();
    await getSubject();
});
</script>

<template>
    <div class="row">
    
        <div class="col">
            <div class="card">
                <div class="card-header pb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0"> ตรวจสอบตารางสอน</h5>
                            <small class="fw-normal text-muted ">ตรวจสอบรายวิชาในภาคเรียน</small>
                        </div>
                        <div>
                            <select v-model="selectedTerm" class="form-control select-year" @change="term">
                                <option value="" disabled>Select term</option>
                                <option v-for="item in terms" :key="item.id" :value="item.t_id">{{ item.t_name }} / {{
                                item.t_year }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 th-1">รายวิชา
                            </th>
                            <th
                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">
                                Value
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                สถานะ</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Refunds</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="items in subjects" :key="items.id">
                            <td>
                                <div class="d-flex px-3 py-1 ">
                                    <!-- <div>
                                        <img src="/public/assets/img/book (5).png" class="avatar me-3" alt="avatar image">
                                    </div> -->
                                    <div class="d-flex flex-column justify-content-center">
                                        <label class="mb-0 ms-0  text-sm   ">{{ items.subjects.s_name }}</label>
                                        <p class="text-sm fw-normal  text-muted mb-0 mt-0">รหัสวิชา <span class="">{{
                                items.subjects.s_num }}</span> </p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="avatar-group mt-2 text-center">
                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Ryan Tompson"
                                        data-bs-original-title="Ryan Tompson">
                                        <img src=" /public/assets/img/team-1.jpg" alt="team1">
                                    </a>
                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Romina Hadid"
                                        data-bs-original-title="Romina Hadid">
                                        <img src=" /public/assets/img/team-2.jpg" alt="team2">
                                    </a>
                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Alexander Smith"
                                        data-bs-original-title="Alexander Smith">
                                        <img src=" /public/assets/img/team-3.jpg" alt="team3">
                                    </a>
                                    <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" aria-label="Jessica Doe"
                                        data-bs-original-title="Jessica Doe">
                                        <img src=" /public/assets/img/team-4.jpg" alt="team4">
                                    </a>
                                </div>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <div v-if="items.docfile.length > 0">

                                    <div v-for="docfile in items.docfile" :key="docfile.df_id">
                                        <div v-for="status in docfile.docfile_status.slice(-1)" :key="status.dfs_id">
                                            <span class="badge bg-gradient-warning shadow "
                                                v-if="status.dfs_status == '0'">Waiting to check
                                            </span>
                                            <span class="badge bg-gradient-success shadow px-4"
                                                v-if="status.dfs_status == '1'">Success
                                            </span>
                                            <span class="badge badge-dark text-dark shadow"
                                                v-if="status.dfs_status == '2'">Make again
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <span class="badge bg-gradient-danger shadow">no documents</span>
                                </div>
                            </td>
                            <td class="align-middle text-end">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn bg-gradient-dark btn-sm mb-0 px-4 shadow fw-normal"
                                        @click="subjects_detail(items.ts_id)">รายละเอียด
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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

.th-1 {
    width: 40% !important;
}
</style>
