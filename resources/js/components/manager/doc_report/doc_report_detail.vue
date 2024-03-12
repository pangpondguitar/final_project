<script setup>
import { onMounted, ref, watch, reactive, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
let user = ref({});
let terms = ref({});
let currentTerm = ref("");
let subjects = ref({});
let selectedTerm = ref("");
let doc_status = ref({});
let doc_sum = ref({});
let program = ref({});
let count_success = ref(0);
let count_wait = ref(0);
let count_doc = ref(0);
let count_sub = ref(0);
let count_redoc = ref(0);

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

let User_pId = ref('')
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

const chartData = computed(() => {
    return {
        labels: ['เสร็จสิ้น', 'รอตรวจสอบ', 'รอจัดทำใหม่', 'ยังไม่จัดทำ'],
        datasets: [{
            data: [count_success.value, count_wait.value, count_redoc.value, count_sub.value],
            backgroundColor: [
                'rgba(61, 247, 79,  0.2)', // เขียว
                'rgba(255, 165, 0, 0.2)', // สีส้ม
                'rgba(255, 0, 0, 0.2)', // แดง
                'rgba(255, 0, 0, 0.2)' // แดง
            ],
            borderColor: [
                'rgba(61, 247, 79, 82)', // เขียว
                'rgba(255, 165, 0, 1)', // สีส้ม
                'rgba(255, 0, 0, 1)',    // แดง
                'rgba(255, 0, 0, 1)'
            ],
            borderWidth: 1
        }]
    };
});
const chartOptions = {
    responsive: true
}
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)


const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        currentTerm.value = terms.value[0].t_id;
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};


const getSubject = async (page = 1) => {
    try {
        let response = await axios.get(`/api/manager_get_subjectAll_term/${props.id}/${currentTerm.value}/?page=${page}`);
        subjects.value = response.data.subjects;
        count_success.value = response.data.count_success;
        count_wait.value = response.data.count_wait;
        count_doc.value = response.data.count_doc;
        count_sub.value = response.data.count_sub;
        count_redoc.value = response.data.count_redoc;
        console.log('subjects', count_sub.value);
        updateChartData();
    } catch (error) {
        console.error('Error fetching subjects:', error);
    }
};
const get_Program = async () => {
    try {
        let response = await axios.get(`/api/manager_get_program/${props.id}`);
        program.value = response.data.program;
        console.log('program', program.value);
    } catch (error) {
        console.error("Error fetching program:", error);
    }
};
const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await getSubject();
};

const updateChartData = () => {
    if (chartData.value && chartData.value.datasets && chartData.value.datasets[0]) {
        chartData.value.datasets[0].data = [count_success.value, count_wait.value, count_doc.value];
    }
};


onMounted(async () => {
    await get_Terms();
    await getSubject();
    await get_Program();
});
</script>

<template>
    <div class="row">
        <div class="col-lg-12 mb-1">
            <h4 class="mb-0">{{ program.p_name }}</h4>
            <p>รายงานการจัดส่ง มคอ.</p>
        </div>
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-body pt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label class=" text-muted ">ตรวจสอบการจัดทำ มคอ.ในภาคเรียน</label>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <select v-model="selectedTerm" class="form-control select-year" @change="term">
                                    <option value="" disabled>Select term</option>
                                    <option v-for="item in terms" :key="item.id" :value="item.t_id">{{ item.t_name }} /
                                        {{
                item.t_year }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">

                            <!-- <div class="row mt-3">
                                <div class="col-3 py-3 ">
                                    <div class="d-flex mb-2">
                                        <div
                                            class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 40 44" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>document</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                                                        fill-rule="nonzero">
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
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Subject</p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{ count_sub }}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-60" role="progressbar" aria-valuenow="60"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 py-3 ">
                                    <div class="d-flex mb-2">
                                        <div
                                            class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-success text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>spaceship</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-1720.000000, -592.000000)" fill="#FFFFFF"
                                                        fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(4.000000, 301.000000)">
                                                                <path class="color-background"
                                                                    d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z">
                                                                </path>
                                                                <path class="color-background"
                                                                    d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z">
                                                                </path>
                                                                <path class="color-background"
                                                                    d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z"
                                                                    opacity="0.598539807"></path>
                                                                <path class="color-background"
                                                                    d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z"
                                                                    opacity="0.598539807"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Success </p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{ count_success }} </h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-90" role="progressbar" aria-valuenow="90"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 py-3 ">
                                    <div class="d-flex mb-2">
                                        <div
                                            class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 43 36" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>credit-card</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                        fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(453.000000, 454.000000)">
                                                                <path class="color-background"
                                                                    d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                    opacity="0.593633743"></path>
                                                                <path class="color-background"
                                                                    d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">Wait</p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{ count_wait }}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-30" role="progressbar" aria-valuenow="30"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-3 py-3 ">
                                    <div class="d-flex mb-2">
                                        <div
                                            class="icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-danger text-center me-2 d-flex align-items-center justify-content-center">
                                            <svg width="10px" height="10px" viewBox="0 0 40 40" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink">
                                                <title>settings</title>
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF"
                                                        fill-rule="nonzero">
                                                        <g transform="translate(1716.000000, 291.000000)">
                                                            <g transform="translate(304.000000, 151.000000)">
                                                                <polygon class="color-background" opacity="0.596981957"
                                                                    points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667">
                                                                </polygon>
                                                                <path class="color-background"
                                                                    d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"
                                                                    opacity="0.596981957"></path>
                                                                <path class="color-background"
                                                                    d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z">
                                                                </path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <p class="text-xs mt-1 mb-0 font-weight-bold">No Document</p>
                                    </div>
                                    <h4 class="font-weight-bolder">{{ count_doc }}</h4>
                                    <div class="progress w-75">
                                        <div class="progress-bar bg-dark w-50" role="progressbar" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row mt-1">
                                <div class="col-lg-3 g-4 ">
                                    <div class="card bg-gradient-success p-1 ">
                                        <div class="card-body text-center   ">
                                            <h6 class="text-white fw-normal">เสร็จสิ้น <i
                                                    class="bi bi-check-circle"></i> </h6>
                                            <h2 class="text-white mb-0">{{ count_success }}</h2>
                                            <p for="" class="text-white mb-0">รายการ</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3  g-4 ">
                                    <div class="card   p-1 card-course-detail">
                                        <div class="card-body text-center   ">
                                            <h6 class=" ">รอตรวจสอบ <i class="bi bi-clock-history"></i></h6>
                                            <h2 class="mb-0 ">{{ count_wait }}</h2>
                                            <p for="" class=" mb-0 ">รายการ</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3  g-4 ">
                                    <div class="card   p-1 card-course-detail">
                                        <div class="card-body text-center   ">
                                            <h6 class=" ">รอจัดทำใหม่ <i class="bi bi-clock-history"></i></h6>
                                            <h2 class="mb-0 ">{{ count_redoc }}</h2>
                                            <p for="" class=" mb-0 ">รายการ</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 g-4  ">
                                    <div class="card  p-1 card-course-detail ">
                                        <div class="card-body text-center   ">
                                            <h6 class="">ยังไม่จัดทำ <i class="bi bi-ban"></i></h6>
                                            <h2 class="mb-0">{{ count_doc }}</h2>
                                            <p for="" class=" mb-0">รายการ</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 col-md-12">
                            <Bar id="my-chart-id" :options="chartOptions" :data="chartData" class="mt-4" />

                        </div>

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

.select-year {
    width: 240px;
    font-size: 16px;
}

.th-1 {
    width: 38% !important;
}

.td-doc {
    width: 50%;
}

.gra-info {
    background: linear-gradient(135deg, #F36265 0%, #961276 100%);
}

.gra-warning {
    background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);
}

.gra-danger {
    background: linear-gradient(135deg, #F36265 0%, #961276 100%);
}
</style>
