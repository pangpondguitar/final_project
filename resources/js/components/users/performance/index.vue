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
let performance = ref([]);
let teacher = ref({});
let selectedTerm = ref("");
const userId = document.getElementById('app').getAttribute('data-user-id');


const getPerformance_file = async () => {
    try {
        let response = await axios.get(`/api/user_get_performance_file/${userId}`);
        performance.value = response.data.performance;
        console.log('performance', performance.value);
    } catch (error) {
        console.error('Error fetching performance:', error);
    }
};
const get_teacher = async () => {
    try {
        let response = await axios.get(`/api/user_get_teacher/${userId}`);
        teacher.value = response.data.teacher;
        console.log(teacher.value);
    } catch (error) {
        console.error('Error fetching performance:', error);
    }
};

const AddPerformance = (id) => {
    router.push('/users/performance/addperformance');
};
const PerformanceEdit = (id) => {
    router.push(`/users/performance/editperformance/${id}`);
};

const PerformanceDetail = (id) => {
    router.push(`/users/performance/performance_detail/${id}`);
};
let input = ref("");
const fruits = ["apple", "banana", "orange"];
function filteredList() {
    return performance.value.filter((item) =>
        item.pf_name.toLowerCase().includes(input.value.toLowerCase()) || item.pf_year.toLowerCase().includes(input.value.toLowerCase())
    );
}
onMounted(async () => {
    await getPerformance_file();
    await get_teacher();
});
</script>

<template>
    <div class="page-header min-height-200 border-radius-xl mt-4"
        style="background-image: url('../../../assets/img/curved-images/curved0.jpg');">
        <span class="mask bg-gradient-primary opacity-6"></span>
    </div>
    <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
        <div class="row gx-4">
            <div class="col-auto" v-for="item in teacher" :key="item.id">
                <div class="avatar avatar-xl position-relative">
                  

                        <img :src="'/uploads/profile_pic/' + item.user_detail.user_d_pic"
                        class="w-100 border-radius-lg shadow-sm" />
                </div>
            </div>
            <div class="col-auto my-auto">
                <div class="h-100" v-for="item in teacher" :key="item.id">
                    <h5 class="mb-1">
                        {{ item.user_detail.user_d_name
                        }}
                    </h5>
                    <p class="mb-0 text-sm">
                        {{ item.user_detail.user_d_name2
                        }}
                    </p>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-8 me-auto text-left">
            <h5>ผลงานทางวิชาการของอาจารย์</h5>
            <p>ผลงานทางวิชาการเป็นข้อมูลที่สำคัญในการแสดงให้เห็นว่าอาจารย์ประจำและนักวิจัยได้สร้างสรรค์ขึ้นเพื่อแสดงให้เห็นถึงความก้าวหน้าทางวิชาการและการพัฒนาองค์ความรู้อย่างต่อเนื่อง.
            </p>

        </div>

    </div>
    <div class="row mb-3">
        <div class="col-lg-4">
            <label for="" class="">ค้นหาผลงานทางวิชาการ</label>
            <input type="text" v-model="input" placeholder="Search Performance..." class="form-control" />

            <div class="item error" v-if="input && !filteredList().length">
                <p>ไม่พบข้อมูล!</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 mb-4" v-for=" item in filteredList()" :key="item.id">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="d-flex">
                        <div class="">
                            <img src="/public/assets/img/pdf (9).png" alt="slack_logo" class="img-perfor">
                        </div>
                        <div class="ms-3 my-auto">


                        </div>
                        <div class="ms-auto">
                            <div class="dropdown">
                                <button class="btn btn-link text-secondary ps-0 pe-2" id="navbarDropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-lg" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end me-sm-n4 me-n3"
                                    aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="javascript:;"
                                        @click="PerformanceDetail(item.pf_id)">ดูรายละเอียด</a>
                                    <a class="dropdown-item" href="javascript:;"
                                        @click="PerformanceEdit(item.pf_id)">แก้ไขข้อมูล</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <h6 class="mb-0">{{ item.pf_name }}</h6>

                    <p class="text-sm mb-0">รายละเอียด : {{ item.pf_detail }} </p>
                    <p class="text-sm mb-0">วันที่ : {{ item.pf_date }} </p>
                    <p class="text-sm mb-3">ปีที่เผยแพร่ : {{ item.pf_year }} </p>
                    <p class="text-sm fw-bold">ไฟล์เอกสาร : {{ item.performance_file.length }} ไฟล์</p>
                    <hr class="horizontal dark">

                </div>
            </div>
        </div>
        <!-- <div class="col-lg-4 mb-4" v-if="!filteredList().length == 0">
            <div class="card h-200 card-add-new-project " @click="AddPerformance()">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <a href="javascript:;">
                        <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                        <h5 class=" text-secondary"> New project </h5>
                    </a>
                </div>
            </div>
        </div> -->
        <div class="col-lg-4 mb-4">
            <div class="card h-200 card-add-new-project " @click="AddPerformance()">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <a href="javascript:;">
                        <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                        <h5 class=" text-secondary"> New project </h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

</template>
<style>
.img-perfor {
    width: 40px;
}

.card-add-new-project {
    height: 240px !important;
}
</style>
