<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { defineProps, defineEmits } from 'vue';
const router = useRouter();
let measure = ref({});
let menu = ref([]);
const edit = ref(false);
menu.value = 1

let formAdd = ref({
    title: '',
    value: ''
});
let formEdit = ref({
    id: '',
    title: '',
    value: ''
});

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

const addMeasure_list = () => {
    const formData = new FormData();
    formData.append("title", formAdd.value.title);
    formData.append("value", formAdd.value.value);
    axios
        .post(`/api/user_add_measure/${props.id}`, formData)
        .then((response) => {
            formAdd.value.title = ''
            formAdd.value.value = ''
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
            getMeasure_list();
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
        title: "ยืนยันลบข้อมูล",
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
                    getMeasure_list();
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
    edit.value = true;
    $('#edit').modal('show');
    formEdit.value = {
        id: item.ml_id,
        title: item.ml_title,
        value: item.ml_value,
    }
}
onMounted(async () => {
    await getMeasure_list();
});
</script>
<template>
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูล</h2>
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
                    <h5 class="mb-0">การวัดและประเมินผลการศึกษา</h5>
                    <label class=" mb-0 ms-0 text-muted">การวัดและประเมินผลการศึกษา
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-5">
                        <input type="text" class="form-control" placeholder="รายการ" v-model="formAdd.title">
                    </div>
                    <div class="col-4">

                        <input type="text" class="form-control" placeholder="ร้อยละ" v-model="formAdd.value">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-dark" @click="addMeasure_list()">เพิ่มข้อมูล</button>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>
                                <label for="" class="text-muted">รายการ</label>
                            </td>
                            <td>
                                <label for="" class="text-muted">ร้อยละ</label>
                            </td>
                            <td>
                                <label for="" class="text-muted">ควบคุม</label>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in measure " :key="item.id">
                            <td>
                                {{ item.ml_title }}
                            </td>
                            <td>
                                {{ item.ml_value }}
                            </td>
                            <td>
                                <div>
                                    <i class="bi bi-pen me-3" @click="openEditModal(item)"></i>
                                    <i class="bi bi-trash3 text-danger" @click="deleteMeasure_list(item.ml_id)"></i>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>


    </div>
</template>


<style></style>
