<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
let user = ref({});
let terms = ref({});
let teachers = ref({});
const userId = document.getElementById('app').getAttribute('data-user-id');
let User_pId = ref('')
let selectedTerm = ref("");
let currentTerm = ref("");
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
const get_Teacher = async () => {
    try {
        console.log(currentTerm.value);
        let response = await axios.get(`/api/president_get_teacher/${User_pId.value}/${currentTerm.value}`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
    } catch (error) {
        console.error("Error fetching user:", error);
    }
};
const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        currentTerm.value = terms.value[0].t_id;
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};
const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await get_Teacher();
};
const Teaching_detail = (id) => {
    router.push(`/president/teaching/teaching_detail/${id}/${currentTerm.value}`);
};

onMounted(async () => {
    await get_Terms();
    await get_UserProgram();
    await get_Teacher();
});
</script>

<template>
    <div class="row">
        <div class="col">
            <div class="card p-1">
                <div class="card-body  pt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0 "> รายการสอนของอาจารย์</h5>
                            <h4 class="fw-normal text-muted h6">รายการสอนของอาจารย์</h4>
                        </div>
                        <div>
                            <select v-model="selectedTerm" class="form-control select-year" @change="term">
                                <option value="" disabled>Select term</option>
                                <option v-for="item in terms" :key="item.id" :value="item.t_id">{{ item.t_name }} /
                                    {{ item.t_year }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 g-4 " v-for="item in teachers" :key="item.id">
                            <div class="card text-start card-teacher-detail" @click="Teaching_detail(item.id)">
                                <div class="d-flex justify-content-center">

                                </div>
                                <a href="javascript:;" class="text-start ms-4">
                                    <img class="img-icon-commit mt-4 text-center"
                                        src="http://[::1]:5173/public/assets/img/user (9).png">
                                </a>
                                <div class="card-body">
                                    <h6 class="card-title mb-0">{{ item.user_detail.user_d_name }}</h6>
                                    <p class="category text-secondary py-0 ">{{ item.user_detail.user_d_name2
                                        }}</p>
                                    <div class="col-12 py-3 ps-0">
                                        <div class="d-flex mb-2">
                                            <div
                                                class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                                                <svg width="10px" height="10px" viewBox="0 0 40 44" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>document</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-1870.000000, -591.000000)"
                                                            fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(154.000000, 300.000000)">
                                                                    <path class="color-background"
                                                                        d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                                                        opacity="0.603585379"></path>
                                                                    <path class="color-background"
                                                                        d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <p class="text-xs mt-1 mb-0 font-weight-bold">รายการสอน</p>
                                        </div>
                                        <h4 class="font-weight-bolder"> {{ item.terms_sub_teaches.length }} <span
                                                class="fs-5 ms-1">วิชา</span></h4>
                                        <div class="progress w-75">
                                            <div class="progress-bar bg-dark w-60" role="progressbar" aria-valuenow="60"
                                                aria-valuemin="0" aria-valuemax="100"></div>
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

<style>
.card-teacher-detail {
    /* border: solid #eee 1px; */
    box-shadow: none;
    background-color: #f4f4f4;
    transition: 0.3s;
}

.card-teacher-detail:hover {
    background-color: #ededed;

    transition: 0.3s;
}
</style>
