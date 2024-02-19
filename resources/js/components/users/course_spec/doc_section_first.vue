<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
const router = useRouter();

let subject = ref({});
let course = ref({});
let form = ref({
    s_num: '',
    s_name: '',
    s_name2: '',
    s_cradit: '',
    title_thai: '',
    title_eng: ''
})

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const getSubject = async () => {
    try {
        let response = await axios.get(`/api/user_get_subject/${props.id}`);
        subject.value = response.data.subject;
        console.log("subject", subject.value);
    } catch (error) {
        console.error('Error fetching subject:', error);
    }
};
const getCourse = async () => {
    try {
        let response = await axios.get(`/api/user_get_course/${props.id}`);
        course.value = response.data.course;
        console.log("course", course.value);
    } catch (error) {
        console.error('Error fetching course:', error);
    }
};
onMounted(async () => {
    await getSubject();
    await getCourse();
});
</script>
<template>
    <div class="col-lg-9">
        <div class="card card-body" id="profile">
            <div class="row justify-content-start align-items-center">
                <div class="col-sm-auto col-4">
                    <div class="avatar avatar-xl position-relative">
                        <img src="../../../assets/img/bruce-mars.jpg" alt="bruce" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-sm-auto col-8 my-auto">
                    <div class="h-100">
                        <h5 class="mb-1 font-weight-bolder">
                            Alec Thompson
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            CEO / Co-Founder
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4" id="basic-info">
            <div class="card-header pt-3">
                <h5 class="mt-2 mb-0">รหัสวิชาและชื่อรายวิชา</h5>

            </div>

            <div class="card-body pt-0">
                <div class="row">
                    <h6 for="" class="mb-2 mt-1">รหัสวิชาและชื่อรายวิชา</h6>
                </div>
                <div class="row">
                    <div class="col-4">
                        <label class="form-label">รหัสวิชา </label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="รหัสวิชา" v-model="subject.s_num" readonly>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ชื่อรายวิชา(ไทย)</label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Thompson" v-model="subject.s_name"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-10">
                        <label class="form-label">ชื่อรายวิชา(อังกฤษ) </label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="รหัสวิชา" v-model="subject.s_name2"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 for="" class="mt-4 mb-0">จำนวนหน่วยกิต</h6>
                </div>
                <div class="row mt-1">
                    <div class="col-4">
                        <label class="form-label">จำนวนหน่วยกิต</label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Thompson" v-model="subject.s_credit"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 for="" class="mt-4 mb-0">ชื่อหลักสูตรและประเภทของรายวิชา</h6>
                </div>
                <div class="row mt-1">
                    <div class="col-5">
                        <label class="form-label">ชื่อหลักสูตร </label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Thompson" v-model="course.c_name" readonly>
                        </div>
                    </div>
                    <div class="col-5">
                        <label class="form-label">ประเภทของรายวิชา </label>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Thompson">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h6 for="" class="mt-4 mb-0">คำอธิบายรายวิชา</h6>
                </div>
                <div class="row mt-1">
                    <div class="col-10">
                        <label class="form-label">ภาษาไทย </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="col-10">
                        <label class="form-label">ภาษาอังกฤษ </label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                </div>
                <div class="row mt-4 ">
                    <div class="col-lg-12">
                        <div class="d-flex">
                            <button class="btn btn-dark me-2">บันทึกข้อมูล</button>
                            <button class="btn btn-outline-secondary">กลับหน้าหลัก</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<style></style>
