<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { defineProps, defineEmits } from 'vue';
const router = useRouter();
let measure = ref({});
let prac = ref({});

const edit = ref(false);
const editList = ref(false);
let topic = ref({})
let menu_detail = ref({});
let prep = ref({})
menu_detail.value = 1
let formAdd = ref({
    title: '',
    value: ''
});
let formEdit = ref({
    id: '',
    title: '',
    value: ''
});

let formLAdd = ref({
    title: ''
});
let formLEdit = ref({
    id: '',
    title: '',
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
const getMeasure_prac_top = async () => {
    try {
        let response = await axios.get(`/api/user_get_measure_prac_top`);
        topic.value = response.data.topic;
    } catch (error) {
        console.error('Error fetching topic:', error);
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

const getMeasure_prac = async () => {
    try {
        let response = await axios.get(`/api/user_get_measure_prac/${props.id}/${menu_detail.value}`);
        prac.value = response.data.prac;
    } catch (error) {
        console.error('Error fetching prac:', error);
    }
};
const addMeasure_prac = () => {
    const formData = new FormData();
    formData.append("title", formLAdd.value.title);
    formData.append("mpt_id", menu_detail.value);
    axios
        .post(`/api/user_add_measure_prac/${props.id}`, formData)
        .then((response) => {
            formLAdd.value.title = ''
            getMeasure_prac()
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const updateMeasure_prac = () => {
    const formData = new FormData();
    formData.append("id", formLEdit.value.id);
    formData.append("title", formLEdit.value.title);
    axios
        .post(`/api/user_update_measure_prac`, formData)
        .then((response) => {
            formLEdit.value.id = '',
                formLEdit.value.title = ''
            getMeasure_prac()
            $('#edit_list').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deleteMeasure_prac = (id) => {
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
                .get("/api/user_delete_measure_prac/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getMeasure_prac()
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
const openEditModalList = (item) => {
    console.log(item);
    editList.value = true;
    $('#edit_list').modal('show');
    formLEdit.value = {
        id: item.mpl_id,
        title: item.mpl_title
    }
}

const menuDetail_select = (id) => {
    menu_detail.value = id
    getMeasure_prac();
}
onMounted(async () => {
    await getMeasure_list();
    await getMeasure_prac_top();
    await getMeasure_prac();
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
    <div class="modal fade" id="edit_list" tabindex="-1" aria-labelledby="edit_list" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูล</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="s_num" class=" py-1 mb-0">แก้ไขข้อมูล</label>
                    <textarea rows="7" class="form-control mb-5" v-model="formLEdit.title"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="updateMeasure_prac()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 ">

        <div class="card " id="basic-info">

            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">การวัดและประเมินผลการปฏิบัติของนักศึกษา</h5>
                    <label class=" mb-0 ms-0 text-muted">การวัดและประเมินผลการปฏิบัติของนักศึกษา
                    </label>
                </div>
            </div>
            <div class="card-body">
                <label class=" mb-0 ms-0 text-muted">1. หลักเกณฑ์การประเมิน
                </label>
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
        <div class="card mt-3" id="basic-info">

            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">การวัดและประเมินผลการปฏิบัติของนักศึกษา</h5>
                    <label class=" mb-0 ms-0 text-muted">การวัดและประเมินผลการปฏิบัติของนักศึกษา
                    </label>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-3 g-4" v-for="item in topic" :key="item.id">
                        <div class="card card-select-doc h-100 menu-detail card-measure-prac"
                            @click="menuDetail_select(item.mpt_id)"
                            :class='{ "menu-detail-active": menu_detail === item.mpt_id }'>
                            <div class="card-body mt-4 d-flex align-items-start">
                                <div class="">
                                    <p class="mb-0 result-title">{{ item.mpt_title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="เพิ่มจุดมุ่งหมายรายวิชา"
                                v-model="formLAdd.title">
                            <button class="btn btn-dark mb-0" type="button" id="button-addon2"
                                @click="addMeasure_prac()">เพิ่มข้อมูล</button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action p-2" v-for="item in prac" :key="item.id">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label for="" class="fw-normal mb-0 text-muted fs-6">{{ item.mpl_title }}
                                </label>
                            </div>
                            <div class="">
                                <i class="bi bi-pen me-3 " @click.prevent="openEditModalList(item)"></i>

                                <i class="bi bi-trash3 text-danger " @click="deleteMeasure_prac(item.mpl_id)"></i>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</template>


<style></style>
