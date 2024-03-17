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
let performance = ref({});
let selectedTerm = ref("");
let form = ref({
    title: '',
    date: '',
    year: '',
    detail: ''
})
const userId = document.getElementById('app').getAttribute('data-user-id');
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});


const getPerformance_fileById = async () => {
    try {
        let response = await axios.get(`/api/user_get_performance_file_byid/${props.id}`);
        performance.value = response.data.performance;
        console.log('performance', performance.value);
    } catch (error) {
        console.error('Error fetching performance:', error);
    }

};
const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await getSubject();
};
const AddPerformance = (id) => {
    router.push('/users/performance/addperformance');
};
const PerformanceHome = (id) => {
    router.push('/users/performance');
};
const FormatDate = (item) => {
    const dateTimeString = item;
    const dateTime = new Date(dateTimeString);

    const thaiDateString = dateTime.toLocaleDateString('th-TH');
    return thaiDateString
};
const FilePerformance = (id) => {
    try {
        window.open(`/api/user_open_performance_file/${id}`, '_blank');
    } catch (error) {
        console.error('Error opening docfile:', error);
    }
};
onMounted(async () => {
    await getPerformance_fileById();
});
</script>

<template>
    <div class="row">
        <div class="col-12 mt-4">
            <!-- <div class="card ">
                <div class="card-header ">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">รายละเอียดผลงานทางวิชาการ</h5>
                            <p class="text-sm">รายละเอียดผลงานทางวิชาการ</p>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">

                </div>

            </div> -->

            <div class="row" v-for="item in performance" :key="item.pf_id">
                <div class="col-lg-5">
                    <!-- <div class="card h-100">
                        <div class="card-body">

                            <h5 class="text-dark mb-0">ชื่อผลงาน</h5>
                            <p>{{ item.pf_name }}</p>
                            <p class="text-sm mb-0">รายละเอียด : {{ item.pf_detail }} </p>
                            <p class="text-sm mb-0">วันที่ : {{ item.pf_date }} </p>
                            <p class="text-sm mb-3">ปีที่เผยแพร่ : {{ item.pf_year }} </p>
                        </div>
                    </div> -->
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-0">รายละเอียดผลงานทางวิชาการ</h6>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="javascript:;">
                                        <i class="fas fa-user-edit text-secondary text-sm" data-bs-toggle="tooltip"
                                            data-bs-placement="top" aria-hidden="true" aria-label="Edit Profile"
                                            data-bs-original-title="Edit Profile"></i><span class="sr-only">Edit
                                            Profile</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body ">
                            <p class="text-sm">
                                ผลงานทางวิชาการเป็นข้อมูลที่สำคัญในการแสดงให้เห็นว่าอาจารย์ประจำและนักวิจัยได้สร้างสรรค์ขึ้นเพื่อแสดงให้เห็นถึงความก้าวหน้าทาง
                                วิชาการและการพัฒนาองค์ความรู้อย่างต่อเนื่อง.
                            </p>
                            <hr class="horizontal gray-light my-4">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">
                                        ชื่อผลงาน :</strong> {{ item.pf_name }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">รายละเอียด
                                        :</strong> {{ item.pf_detail }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">วันที่
                                        :</strong> {{ FormatDate(item.pf_date) }}</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">ปีที่เผยแพร่
                                        :</strong> {{ item.pf_year }} </li>
                                <li class="list-group-item border-0 ps-0 pb-0">
                                    <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                    <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-facebook fa-lg" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-twitter fa-lg" aria-hidden="true"></i>
                                    </a>
                                    <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                        <i class="fab fa-instagram fa-lg" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>
                <div class="col-lg-7">
                    <div class="card h-100">
                        <div class="card-body">

                            <h6 class="mb-0">ไฟล์เอกสารผลงานทางวิชาการ</h6>
                            <p class="text-sm text-danger mt-4  ">ไฟล์เอกสาร : {{ item.performance_file.length }} ไฟล์
                            </p>
                            <ul class="list-group list-group-flush" v-if="item.performance_file.length > 0">
                                <li class="list-group-item px-0" v-for="file in item.performance_file"
                                    :key="file.pff_id">

                                    <a class="d-flex align-items-center px-0 text-muted"
                                        @click="FilePerformance(file.pff_id)">
                                        <div class="me-3">
                                            <img src="/public/assets/img/pdf (9).png" alt="slack_logo"
                                                class="img-perfor">
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 fz-link-file"> {{ file.pff_name }}</p>
                                        </div>
                                    </a>

                                </li>
                            </ul>
                            <p v-else class="text-sm">ไม่มีไฟล์เอกสารที่เกี่ยวข้อง</p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-12">

                    <button class="btn bg-gradient-dark mt-4" @click="PerformanceHome()">กลับหน้าหลัก</button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.img-perfor {
    width: 40px;
}

.fz-link-file {
    font-size: 14px !important;
}
</style>
