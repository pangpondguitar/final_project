<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
import { Bar } from 'vue-chartjs'
let course = ref({});
let subject = ref({});
let subject_count = ref('');
let course_committee_count = ref('');
let course_committee = ref({});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

const get_Course = async () => {
    try {
        let response = await axios.get(`/api/president_get_single_course/${props.id}`);
        course.value = response.data.course;
        subject.value = response.data.subject;
        course_committee.value = response.data.course_committee;
        subject_count.value = subject.value.length;
        course_committee_count.value = course_committee.value.length;
    } catch (error) {
        console.error("Error fetching course:", error);
    }
};

const Course_Home = () => {
    router.push('/president/course');
};

onMounted(async () => {
    await get_Course();
});
</script>


<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-4 ">
                    <h4 class="fw-normal text-muted h6">รายละเอียดข้อมูลหลักสูตร</h4>
                    <div class="row ">
                        <div class=" col-lg-12  ">
                            <div class="card p-3  card-course-details">
                                <h4 class="mt-lg-0 mt-4 pb-0 mb-0   text-info text-gradient ">{{ course.c_name }}</h4>
                                <p class="mt-0">{{ course.c_name2 }}</p>
                                <div class="rating">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star-half-alt" aria-hidden="true"></i>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-lg-4">
                                        <div class="d-flex ">
                                            <div>
                                                <div
                                                    class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md ">
                                                    <i class="ni ni-money-coins text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0">รายวิชาในหลักสูตรทั้งหมด</h6>
                                                <p>{{ subject_count }} รายวิชา</p>
                                            </div>
                                        </div>
                                        <div class="d-flex   ">
                                            <div>
                                                <div
                                                    class="icon icon-shape bg-gradient-dark shadow text-center border-radius-md ">
                                                    <i class="ni ni-money-coins text-lg opacity-10"
                                                        aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 ">คณะกรรมการหลักสูตร </h6>
                                                <p>{{ course_committee_count }} ท่าน</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex  ">
                                            <div>
                                                <img class="course-file" src=" /public/assets/img/pdf (9).png">
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0">ไฟล์เอกสารหลักสูตร</h6>
                                                <p>Document</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-5 mb-0">
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-lg-12 p-4 pb-0 mb-3">
                            <div>
                                <h5 class="text-info text-dark">คณะกรรมการหลักสูตรทั้งหมด</h5>
                                <p class="mb-0">คณะกรรมการหลักสูตร {{ course_committee_count }} ท่าน</p>
                            </div>
                        </div>
                        <div class="col-lg-3 g-4 " v-for="item in course_committee" :key="item.id">
                            <div class="card text-center card-course-detail">
                                <div class="d-flex justify-content-end">

                                </div><a href="javascript:;"><img class="img-icon-commit mt-4"
                                        src="http://[::1]:5173/public/assets/img/man (1).png"></a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ item.user.user_detail.user_d_name }}</h5>
                                    <h6 class="category text-info text-gradient">{{ item.user.user_detail.user_d_name2
                                        }}</h6>
                                    <p class="card-description"> "Don't walk behind me; I may not lead. Don't walk in
                                        front of me; I may not follow. Just walk beside me and be my friend." </p>
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
.card-course-detail {
    border-radius: 14px !important;
    /* border: solid #eee 1px; */
    box-shadow: none;
    background-color: #f4f4f4;
}

.card-course-details {
    border-radius: 14px !important;
    /* border: solid #eee 1px; */
    box-shadow: none;
    /* background-color: #f4f4f4; */
}

.course-file {
    width: 50px;
}
</style>
