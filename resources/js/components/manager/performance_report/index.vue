<script setup>
import { useRouter } from "vue-router";
import axios from "axios";
import { onMounted, ref, watch, reactive, computed } from "vue";
const router = useRouter();
let programs = ref([]);
let currentTerm = ref("");
let terms = ref({});

let subjects = ref({});
let doc_status = ref({});
let doc_sum = ref({});
let program = ref({});
let count_success = ref(0);
let count_wait = ref(0);
let count_doc = ref(0);
let count_sub = ref(0);
let count_redoc = ref(0);

let year = ref([]);
let count_per = ref([]);

let labels = ref([]);
let data = ref([]);
let yearOptions = ref([]);
let selectedYear = ref("");
let currentYear = ref((new Date().getFullYear() + 543).toString());
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

    const distinctColors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ff8000', '#80ff00', '#0080ff', '#ff0080', '#80ff80', '#8080ff', '#ff80ff', '#80ffff', '#ffff80', '#ff8080', '#808080'];

// Map distinct colors to RGBA format for backgroundColor
const backgroundColor = distinctColors.map(color => `rgba(${parseInt(color.substr(1,2), 16)}, ${parseInt(color.substr(3,2), 16)}, ${parseInt(color.substr(5,2), 16)}, 0.2)`);

// Map distinct colors to RGBA format for borderColor
const borderColor = distinctColors.map(color => `rgba(${parseInt(color.substr(1,2), 16)}, ${parseInt(color.substr(3,2), 16)}, ${parseInt(color.substr(5,2), 16)}, 1)`);
    return {
        labels: labels.value,
        datasets: [
            {
                data: data.value,
                backgroundColor: backgroundColor,
                borderColor:borderColor,
                borderWidth: 1,
            },
        ],
        options: {
            // Other chart options...
            layout: {
                padding: {
                    // Adjust padding if needed
                },
            },
            // Define height and width
            height: 200, // Specify the desired height of the chart
            width: 600, // Specify the desired width of the chart
        },
    };
});
const generateDistinctColors = () => {
      const distinctColors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ff8000', '#80ff00', '#0080ff', '#ff0080', '#80ff80', '#8080ff', '#ff80ff', '#80ffff', '#ffff80', '#ff8080', '#808080'];
      backgroundColor.value = distinctColors.map(color => `rgba(${parseInt(color.substr(1,2), 16)}, ${parseInt(color.substr(3,2), 16)}, ${parseInt(color.substr(5,2), 16)}, 0.2)`);
      borderColor.value = distinctColors.map(color => `rgba(${parseInt(color.substr(1,2), 16)}, ${parseInt(color.substr(3,2), 16)}, ${parseInt(color.substr(5,2), 16)}, 1)`);
    };
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
const get_count_Performance = async () => {
    try {
        let response = await axios.get(
            `/api/manager_get_doc_performance/${selectedYear.value}`
        );

        year.value = response.data.year;
        count_per.value = response.data.count_per;
        console.log("count_per", count_per.value);
        console.log("year", year.value);

        labels.value = Object.keys(count_per.value).map(
            (key) => count_per.value[key].name
        );
        data.value = Object.keys(count_per.value).map(
            (key) => count_per.value[key].count
        );

        console.log("count_per", labels.value);
        console.log("year", data.value);
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
const term = (event) => {
    const year = event.target.value;
    selectedYear.value = year;
    console.log(selectedYear.value);
    get_count_Performance();
};
const doc_report_detail = (id) => {
    router.push("/manager/doc_report/doc_report_detail/" + id);
};
const generateYearOptions = () => {
    const currentYear = new Date().getFullYear() + 543; // Current year in Buddhist calendar
    for (let i = 0; i < 5; i++) {
        yearOptions.value.push(currentYear - i);
    }
    selectedYear.value = currentYear;
};

onMounted(async () => {
    await getProgram();
    await get_Terms();
    await get_count_Doc();
    await generateYearOptions();
    await get_count_Performance();
 
});
</script>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-3">
                <div class="card-header pb-0">
                    <div>
                        <h5 class="mb-1">
                            รายงานสรุปการจัดทำผลงานของอาจารย์ {{ selectedYear }}
                        </h5>
                        <h6 class="fw-normal text-sm mb-4">
                            รายงานสรุปการจัดทำผลงานของอาจารย์
                        </h6>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div>
                        <label for="" class="text-sm"
                            >เลือกปีที่ต้องการค้นหา</label
                        >
                       
                        <select v-model="selectedYear" class="form-control select-year"   @change="term">
                            <option
                                v-for="year in yearOptions"
                                :key="year"
                                :value="year"
                             
                            >
                                {{ year }}
                            </option>
                        </select>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-sm-12 col-md-12">
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
       
    </div>
</template>

<style>
.text-truncate {
    max-width: 80%;
}
</style>
