<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
let user = ref({});
let program = ref("");
let course = ref({});
let teacher_count = ref('');

const userId = document.getElementById('app').getAttribute('data-user-id');
let User_pId = ref('')

const get_UserProgram = async () => {
    try {
        let response = await axios.get(`/api/president_get_user_data/${userId}`);
        user.value = response.data.user;
        User_pId.value = user.value.p_id
    } catch (error) {
        console.error("Error fetching user:", error);
    }
};

const get_Program = async () => {
    try {
        let response = await axios.get(`/api/president_get_program/${User_pId.value}`);
        program.value = response.data.program;
        course.value = response.data.course;
        teacher_count.value = response.data.teacher_count;
        console.log('program', program.value);
    } catch (error) {
        console.error("Error fetching program:", error);
    }
};

const Course_detail = (id) => {
    router.push('/president/course/course_detail/' + id);
};

onMounted(async () => {
    await get_UserProgram();
    await get_Program();
});
</script>

<template>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body pt-3 ">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0 "> หลักสูตรทั้งหมด</h5>
                            <h4 class="fw-normal text-muted h6">หลักสูตรทั้งหมด</h4>
                        </div>
                    </div>



                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body pt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0 "> หลักสูตรทั้งหมด</h5>
                            <h4 class="fw-normal text-muted h6">หลักสูตรทั้งหมด</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
