<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
let topic = ref({})
let menu_detail = ref({});
let prep = ref({})
menu_detail.value = 1
const editing = ref(false);
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
let formAdd = ref({
    title: '',
});
let formEdit = ref({
    id: '',
    title: ''
});

const getPrep_plan_top = async () => {
    try {
        let response = await axios.get(`/api/user_get_prepplan_top`);
        topic.value = response.data.topic;
    } catch (error) {
        console.error('Error fetching topic:', error);
    }
};
const getPrep_plan = async () => {
    try {
        let response = await axios.get(`/api/user_get_prepplan/${props.id}/${menu_detail.value}`);
        prep.value = response.data.prep;
    } catch (error) {
        console.error('Error fetching prep:', error);
    }
};
const addPrep_plan = () => {
    const formData = new FormData();
    formData.append("title", formAdd.value.title);
    formData.append("ppt_id", menu_detail.value);
    axios
        .post(`/api/user_add_prepplan/${props.id}`, formData)
        .then((response) => {
            formAdd.value.title = ''
            getPrep_plan()
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const updatePrep_plan = () => {
    const formData = new FormData();
    formData.append("id", formEdit.value.id);
    formData.append("title", formEdit.value.title);
    axios
        .post(`/api/user_update_prepplan`, formData)
        .then((response) => {
            formEdit.value.id = '',
                formEdit.value.title = ''
            getPrep_plan()
            $('#edit').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deletePrep_plan = (id) => {
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
                .get("/api/user_delete_prepplan/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getPrep_plan()
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
        id: item.ppl_id,
        title: item.ppl_title
    }
}
const menuDetail_select = (id) => {
    menu_detail.value = id
    getPrep_plan();
}


onMounted(async () => {
    await getPrep_plan_top();
    await getPrep_plan();
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
                    <label for="s_num" class=" py-1 mb-0">แก้ไขข้อมูล</label>
                    <textarea rows="7" class="form-control mb-5" v-model="formEdit.title"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="updatePrep_plan()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 ">
        <div class="card " id="basic-info">
            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">การวางแผนและการเตรียมการ</h5>
                    <label class=" mb-0 ms-0 text-muted">การวางแผนและการเตรียมการ
                    </label>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 g-4" v-for="item in topic" :key="item.id">
                        <div class="card card-select-doc h-100 menu-detail card-prep-menu"
                            @click="menuDetail_select(item.ppt_id)"
                            :class='{ "menu-detail-active": menu_detail === item.ppt_id }'>
                            <div class="card-body mt-4 d-flex align-items-start">
                                <div class="">
                                    <p class="mb-0 result-title">{{ item.ppt_title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="เพิ่มจุดมุ่งหมายรายวิชา"
                                v-model="formAdd.title">
                            <button class="btn btn-dark mb-0" type="button" id="button-addon2"
                                @click="addPrep_plan()">เพิ่มข้อมูล</button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action p-2" v-for="item in prep" :key="item.id">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label for="" class="fw-normal mb-0 text-muted fs-6">{{ item.ppl_title }}
                                </label>
                            </div>
                            <div class="">
                                <i class="bi bi-pen me-3 " @click.prevent="openEditModal(item)"></i>

                                <i class="bi bi-trash3 text-danger " @click="deletePrep_plan(item.ppl_id)"></i>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>


<style>
.card-prep-menu {

    height: 160px !important;
}
</style>
