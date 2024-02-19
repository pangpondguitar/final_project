<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { defineProps, defineEmits } from 'vue';
const router = useRouter();
let subject = ref({});
let menu = ref([]);
menu.value = 1
let form = ({
    week: '',
    hour: ''
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
    } catch (error) {
        console.error('Error fetching subject:', error);
    }
};

const teaching_sub = (id) => {
    router.push('/admin/teaching/teaching_sub/' + id);
};
const handleMenuClick = (value) => {
    menu.value = value
};
onMounted(async () => {
    await getSubject();
});
</script>
<template>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">เพิ่มสัปดาห์การสอน</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-1">
                        <label for="s_num" class="fs-6 py-1 mb-0">สัปดาห์ที่สอน</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_num"
                            v-model="form.week">
                        <label for="s_name" class="fs-6 py-1 mb-0">จำนวนชั่วโมง</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_name"
                            v-model="form.hour">


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="saveSubject()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 ">

        <div class="card " id="basic-info">

            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">การวัดและประเมินผลการศึกษา</h5>
                        <label class=" mb-0 ms-0 text-muted">การวัดและประเมินผลการศึกษา
                        </label>
                    </div>
                    <div class="">
                        <button class="btn btn-dark">เพิ่มข้อมูล</button>
                    </div>
                </div>

            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 for="" class="fw-normal mb-0 text-muted"> A second item</h6>
                            </div>
                            <div>
                                <i class="bi bi-pen me-3"></i>
                                <i class="bi bi-trash3 text-danger"></i>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 for="" class="fw-normal mb-0 text-muted"> A second item</h6>
                            </div>
                            <div>
                                <i class="bi bi-pen me-3"></i>
                                <i class="bi bi-trash3 text-danger"></i>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 for="" class="fw-normal mb-0 text-muted"> A second item</h6>
                            </div>
                            <div>
                                <i class="bi bi-pen me-3"></i>
                                <i class="bi bi-trash3 text-danger"></i>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item list-group-item-action">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 for="" class="fw-normal mb-0 text-muted"> A second item</h6>
                            </div>
                            <div>
                                <i class="bi bi-pen me-3"></i>
                                <i class="bi bi-trash3 text-danger"></i>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>


    </div>
</template>


<style></style>
