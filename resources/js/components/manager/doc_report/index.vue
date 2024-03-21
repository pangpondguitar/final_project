<script setup>
import { useRouter } from "vue-router";
import axios from "axios";
import { onMounted, ref, watch, reactive, computed } from "vue";
const router = useRouter();
let programs = ref([]);
let currentTerm = ref("");
let terms = ref({});
let selectedTerm = ref("");

let subjects = ref({});
let doc_status = ref({});
let doc_sum = ref({});
let program = ref({});
let count_success = ref(0);
let count_wait = ref(0);
let count_doc = ref(0);
let count_sub = ref(0);
let count_redoc = ref(0);

import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

const chartData = computed(() => {
    return {
        labels: ["เสร็จสิ้น", "รอตรวจสอบ", "รอจัดทำใหม่", "ยังไม่จัดทำ"],
        datasets: [
            {
                data: [
                    count_success.value,
                    count_wait.value,
                    count_redoc.value,
                    count_sub.value,
                ],
                backgroundColor: [
                    "rgba(61, 247, 79,  0.2)", // เขียว
                    "rgba(255, 165, 0, 0.2)", // สีส้ม
                    "rgba(255, 0, 0, 0.2)", // แดง
                    "rgba(255, 0, 0, 0.2)", // แดง
                ],
                borderColor: [
                    "rgba(61, 247, 79, 82)", // เขียว
                    "rgba(255, 165, 0, 1)", // สีส้ม
                    "rgba(255, 0, 0, 1)", // แดง
                    "rgba(255, 0, 0, 1)",
                ],
                borderWidth: 1,
            },
        ],
    };
});
const chartOptions = {
    responsive: true,
};
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

const getProgram = async () => {
    try {
        let response = await axios.get("/api/get_all_programs");
        programs.value = response.data.programs;
        console.log("programs", programs.value);
    } catch (error) {
        console.error("Error fetching programs:", error);
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
const get_count_Doc = async () => {
    try {
        let response = await axios.get(
            `/api/manager_get_doc_status_count/${currentTerm.value}`
        );
        subjects.value = response.data.subjects;
        count_success.value = response.data.count_success;
        count_wait.value = response.data.count_wait;
        count_doc.value = response.data.count_doc;
        count_sub.value = response.data.count_sub;
        count_redoc.value = response.data.count_redoc;
        console.log("subjects", count_sub.value);
        updateChartData();
    } catch (error) {
        console.error("Error fetching programs:", error);
    }
};
const updateChartData = () => {
    if (
        chartData.value &&
        chartData.value.datasets &&
        chartData.value.datasets[0]
    ) {
        chartData.value.datasets[0].data = [
            count_success.value,
            count_wait.value,
            count_re_doc.value,
            count_doc.value,
        ];
    }
};
const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await get_count_Doc();
};
const doc_report_detail = (id) => {
    router.push("/manager/doc_report/doc_report_detail/" + id);
};

onMounted(async () => {
    await getProgram();
    await get_Terms();
    await get_count_Doc();
});
</script>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-3">
                <div class="card-header pb-0">
                    <div>
                        <h4 class="fw-normal mb-0">รายงานสรุปการจัดส่ง มคอ.</h4>
                        <h6 class="fw-normal text-sm mb-4">
                            รายงานสรุปการจัดทำ มคอ. รายภาคเรียน
                        </h6>
                    </div>
                    <div>
                        <label for="" class="text-sm"
                            >เลือกภาคเรียนการศึกษา</label
                        >
                        <select
                            v-model="selectedTerm"
                            class="form-control select-year"
                            @change="term"
                        >
                            <option value="" disabled>Select term</option>
                            <option
                                v-for="item in terms"
                                :key="item.id"
                                :value="item.t_id"
                            >
                                {{ item.t_name }} / {{ item.t_year }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row mt-1">
                        <div class="col-lg-3 g-4">
                            <div class="card bg-gradient-success p-1">
                                <div class="card-body text-center">
                                    <h6 class="text-white fw-normal">
                                        เสร็จสิ้น
                                        <i class="bi bi-check-circle"></i>
                                    </h6>
                                    <h2 class="text-white mb-0">
                                        {{ count_success }}
                                    </h2>
                                    <p for="" class="text-white mb-0">รายการ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 g-4">
                            <div class="card p-1 card-course-detail">
                                <div class="card-body text-center">
                                    <h6 class=" ">
                                        รอตรวจสอบ
                                        <i class="bi bi-clock-history"></i>
                                    </h6>
                                    <h2 class="mb-0">
                                        {{ count_wait }}
                                    </h2>
                                    <p for="" class="mb-0">รายการ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 g-4">
                            <div class="card p-1 card-course-detail">
                                <div class="card-body text-center">
                                    <h6 class=" ">
                                        รอจัดทำใหม่
                                        <i class="bi bi-clock-history"></i>
                                    </h6>
                                    <h2 class="mb-0">
                                        {{ count_redoc }}
                                    </h2>
                                    <p for="" class="mb-0">รายการ</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 g-4">
                            <div class="card p-1 card-course-detail">
                                <div class="card-body text-center">
                                    <h6 class="">
                                        ยังไม่จัดทำ
                                        <i class="bi bi-ban"></i>
                                    </h6>
                                    <h2 class="mb-0">
                                        {{ count_doc }}
                                    </h2>
                                    <p for="" class="mb-0">รายการ</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-0 mt-5">แผนภาพแสดงสถานะการจัดส่ง มคอ.</h5>
                    <label class="mt-0 text-muted ms-0 fw-normal"
                        >ตรวจสอบการจัดทำ มคอ.ในภาคเรียน</label
                    >
                    <div class="d-flex justify-content-center">
                        <div class="col-lg-8 col-sm-12 col-md-12">
                            <Bar
                                id="my-chart-id"
                                :options="chartOptions"
                                :data="chartData"
                                class="mt-2"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">สาขาวิชา</h5>
                            <p class="text-sm">สาขาทั้งหมด</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3" v-if="programs.length > 0">
                    <ul
                        class="list-group"
                        v-for="item in programs"
                        :key="item.id"
                    >
                        <li
                            class="list-group-item border-0 d-flex align-items-center px-0 mb-2"
                        >
                            <div class="avatar me-3">
                                <img
                                    src="/public/assets/img/book (5).png"
                                    alt="kal"
                                    class="border-radius-lg shadow"
                                    style="padding: 8px"
                                />
                            </div>
                            <div
                                class="d-flex align-items-start flex-column justify-content-center"
                            >
                                <h6 class="mb-0">{{ item.p_name }}</h6>
                                <p class="mb-0 text-xs text-truncate">
                                    {{ item.p_detail }}
                                </p>
                            </div>
                            <button
                                class="btn btn-link pe-3 ps-0 mb-0 ms-auto"
                                @click="doc_report_detail(item.p_id)"
                            >
                                ดูข้อมูล
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.text-truncate {
    max-width: 80%;
}
</style>
