<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { defineProps, defineEmits } from 'vue';
const router = useRouter();
let measure = ref({});
let menu = ref([]);
let teachers = ref({});
menu.value = 1
let formAdd = ({
    title: '',
    value: ''
})
let formEdit = ({
    id: '',
    title: '',
    value: ''
})
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const getMeasure_list = async () => {
    try {
        let response = await axios.get(`/api/user_get_measure/${props.id}`);
        measure.value = response.data.measure;
    } catch (error) {
        console.error('Error fetching measure:', error);
    }
};
const get_teachers = async () => {
    try {
        let response = await axios.get(`/api/get_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const addMeasure_list = () => {
    const formData = new FormData();
    formData.append("title", formAdd.value.title);
    formData.append("value", formAdd.value.value);
    axios
        .post(`/api/user_add_measure/${props.id}`, formData)
        .then((response) => {
            formAdd.value.title = ''
            formAdd.value.title = ''
            getMeasure_list();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const updateMeasure_list = () => {
    const formData = new FormData();
    formData.append("id", formEdit.value.id);
    formData.append("title", formEdit.value.title);
    formData.append("value", formEdit.value.value);
    axios
        .post(`/api/user_update_measure`, formData)
        .then((response) => {
            formEdit.value.id = '',
                formEdit.value.title = '',
                formEdit.value.value = ''

            $('#edit').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deleteMeasure_list = (id) => {
    Swal.fire({
        title: "ยืนยันลบข้อมูลสัปดาห์",
        text: 'ยืนยันลบข้อมูล',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/user_delete_measure/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                })
                .catch(() => {
                    Swal.fire(
                        "Failed!!",
                        "There was somthing wrong",
                        "Warning"
                    );
                });
        }
    });
};
const openEditModal = (item) => {
    console.log(item);
    editing.value = true;
    $('#edit').modal('show');
    formEdit.value = {
        id: item.pw_id,
        title: item.title,
        value: item.value,
    }
}
onMounted(async () => {
    await get_teachers();
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
                            v-model="formEdit.title">
                        <label for="s_name" class="fs-6 py-1 mb-0">จำนวนชั่วโมง</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_name"
                            v-model="formEdit.value">


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="updateMeasure_list()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 ">

        <div class="card " id="basic-info">

            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">คณะกรรมการบริหารรายวิชา/อาจารย์ผู้สอนรายวิชา</h5>
                    <label class=" mb-0 ms-0 text-muted">คณะกรรมการบริหารรายวิชา/อาจารย์ผู้สอนรายวิชา
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-4">
                    <h6>คณะกรรมการบริหารรายวิชา</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group list-group-flush" v-for="teacher in teachers" :key="teacher.ts_id">
                            <li class="list-group-item list-group-item-action" v-for="termTeach in teacher.terms_sub_teach"
                                :key="termTeach.tst_id">

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 for="" class="fw-normal mb-0 text-muted"> {{
                                            termTeach.users.user_detail.user_d_name
                                        }}
                                        </h6>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <h6>อาจารย์ผู้สอนรายวิชา</h6>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-group list-group-flush" v-for="teacher in teachers" :key="teacher.ts_id">
                            <li class="list-group-item list-group-item-action" v-for="termTeach in teacher.terms_sub_teach"
                                :key="termTeach.tst_id">

                                <div class="d-flex justify-content-start">
                                    <div class="me-2">
                                        <div>
                                            <i class="ni ni-circle-08 text-dark text-gradient text-lg opacity-10 mt-1"
                                                aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 for="" class="fw-normal mb-0 text-muted"> {{
                                            termTeach.users.user_detail.user_d_name
                                        }}
                                        </h6>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>


<style></style>
