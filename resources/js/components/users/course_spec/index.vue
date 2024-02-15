
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
        <!-- <div class="col-lg-5 ">
            <div class="row">
                <div class="col">
                    <div class="card bg-gradient-primary">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8 my-auto">
                                    <div class="numbers">
                                        <p class="text-white text-sm mb-0 text-capitalize font-weight-bold opacity-7">
                                            Wheather today</p>
                                        <h5 class="text-white font-weight-bolder mb-0">
                                            San Francisco - 29°C
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <img class="w-50" src="../../assets/img/small-logos/icon-sun-cloud.png" alt="image sun">
                                    <h5 class="mb-0 text-white text-end me-1">Cloudy</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h1 class="text-gradient text-primary"><span id="status1" countto="21">21</span> <span
                                    class="text-lg ms-n2">°C</span></h1>
                            <h6 class="mb-0 font-weight-bolder">Living Room</h6>
                            <p class="opacity-8 mb-0 text-sm">Temperature</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-md-0 mt-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h1 class="text-gradient text-primary"> <span id="status2" countto="44">44</span> <span
                                    class="text-lg ms-n1">%</span></h1>
                            <h6 class="mb-0 font-weight-bolder">Outside</h6>
                            <p class="opacity-8 mb-0 text-sm">Humidity</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col">
            <div class="card">
                <div class="card-header px-3 py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0"> ตรวจสอบตารางสอน</h5>
                            <h4 class="fw-normal text-muted h6">ตรวจสอบรายวิชาในภาคเรียน</h4>
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
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Value
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
                                <div class="d-flex px-3 ">
                                    <!-- <div>
                                        <img src="/public/assets/img/book (5).png" class="avatar me-3" alt="avatar image">
                                    </div> -->
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 fw-semibold">{{ items.subjects.s_name }}</h6>
                                        <p class="text-sm fw-normal  text-secondary mb-0">รหัสวิชา <span
                                                class="text-success">{{ items.subjects.s_num }}</span> </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">$130.992</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-success">Success</span>
                            </td>
                            <td class="align-middle text-end">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button class="btn btn-dark btn-sm mb-0 px-4"
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
    width: 45%;
}
</style>


