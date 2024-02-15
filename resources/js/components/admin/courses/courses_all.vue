
<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
let courses = ref([]);
let program = ref([]);
let form = ref({
    c_name: '',
    c_name2: ''
})
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_courses = async () => {
    try {
        let response = await axios.get(`/api/admin_get_courses/${props.id}`);
        courses.value = response.data.courses;
        console.log('courses', courses.value);
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};
const get_program = async () => {
    try {
        let response = await axios.get(`/api/admin_get_courses_program/${props.id}`);
        program.value = response.data.program;
    } catch (error) {
        console.error("Error fetching program:", error);
    }
};

const courses_detail = (id) => {
    router.push('/admin/courses/course_detail/' + id);
};

const save_course = () => {
    const formData = new FormData();
    formData.append("c_name", form.value.c_name);
    formData.append("c_name2", form.value.c_name2);
    formData.append("id", props.id);
    axios
        .post("/api/admin_add_course", formData)
        .then((response) => {
            form.value.c_name = '',
                form.value.c_name2 = ''

            get_courses();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};


onMounted(async () => {
    await get_program();
    await get_courses();
});
</script>

<template>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">เพิ่มหลักสูตร</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="name" class="fs-6 mt-1 mb-0">ป้อนชื่อหลักสูตร</label>
                    <input type="text" class="form-control" placeholder="ป้อนชื่อสาขา" id="name" v-model="form.c_name"
                        required>
                    <label for="name2" class="fs-6 mt-1 mb-0">ชื่อหลักสูตรภาษาอังกฤษ</label>
                    <input type="text" class="form-control" placeholder="ป้อนรายละเอียดข้อมูลสาขา" id="name2"
                        v-model="form.c_name2" required>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="save_course(id)">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ program.p_name }}</h5>
                            <p class="text-sm">หลักสูตรทั้งหมด</p>
                        </div>
                        <div>
                            <div>
                                <a href="" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">เพิ่มหลักสูตร</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12" v-for="item in courses" :key="item.id">
                            <div class="card bg-gradient-default my-1">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title text-dark text-gradient"> {{ item.c_name }}</h5>

                                            <blockquote class="blockquote text-white mb-0">
                                                <p class="text-dark ms-3"> {{ item.c_name2 }}</p>
                                                <footer class="blockquote-footer text-gradient text-info text-sm ms-3">
                                                    Someone famous in <cite title="Source Title">Source Title</cite>
                                                </footer>
                                            </blockquote>
                                        </div>
                                        <div>
                                            <button class="btn btn-outline-info"
                                                @click="courses_detail(item.c_id)">ดูรายละเอียด</button>
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


