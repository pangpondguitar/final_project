<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
let topic = ref({})
let menu_detail = ref({});
let adjust = ref({})
let adjustR = ref({})
menu_detail.value = 1
const editing = ref(false);
const editing_r = ref(false);
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
let formRAdd = ref({
    title: '',
});
let formREdit = ref({
    id: '',
    title: ''
});

const getAdjust_people_top = async () => {
    try {
        let response = await axios.get(`/api/user_get_adjust_people_top`);
        topic.value = response.data.topic;
    } catch (error) {
        console.error('Error fetching topic:', error);
    }
};
const getAdjust_people = async () => {
    try {
        let response = await axios.get(`/api/user_get_adjust_people/${props.id}/${menu_detail.value}`);
        adjust.value = response.data.adjust;
    } catch (error) {
        console.error('Error fetching adjust:', error);
    }
};
const addAdjust_people = () => {
    const formData = new FormData();
    formData.append("title", formAdd.value.title);
    formData.append("apt_id", menu_detail.value);
    axios
        .post(`/api/user_add_adjust_people/${props.id}`, formData)
        .then((response) => {
            formAdd.value.title = ''
            getAdjust_people()
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const updateAdjust_people = () => {
    const formData = new FormData();
    formData.append("id", formEdit.value.id);
    formData.append("title", formEdit.value.title);
    axios
        .post(`/api/user_update_adjust_people`, formData)
        .then((response) => {
            formEdit.value.id = '',
                formEdit.value.title = ''
            getAdjust_people()
            $('#edit').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deleteAdjust_people = (id) => {
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
                .get("/api/user_delete_adjust_people/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getAdjust_people()
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

const getAdjust_repeat = async () => {
    try {
        let response = await axios.get(`/api/user_get_adjust_repeat/${props.id}`);
        adjustR.value = response.data.adjust_r;
    } catch (error) {
        console.error('Error fetching adjust:', error);
    }
};
const addAdjust_repeat = () => {
    const formData = new FormData();
    formData.append("title", formRAdd.value.title);
    axios
        .post(`/api/user_add_adjust_repeat/${props.id}`, formData)
        .then((response) => {
            formRAdd.value.title = ''
            getAdjust_repeat()
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const updateAdjust_repeat = () => {
    const formData = new FormData();
    formData.append("id", formREdit.value.id);
    formData.append("title", formREdit.value.title);
    axios
        .post(`/api/user_update_adjust_repeat`, formData)
        .then((response) => {
            formREdit.value.id = '',
                formREdit.value.title = ''
            getAdjust_repeat()
            $('#edit_repeat').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deleteAdjust_repeat = (id) => {
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
                .get("/api/user_delete_adjust_repeat/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getAdjust_repeat()
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
        id: item.apl_id,
        title: item.apl_title
    }
}
const openEditModal_repeat = (item) => {
    console.log(item);
    editing_r.value = true;
    $('#edit_repeat').modal('show');
    formREdit.value = {
        id: item.adr_id,
        title: item.adr_title
    }
}
const menuDetail_select = (id) => {
    menu_detail.value = id
    getAdjust_people();
}


onMounted(async () => {
    await getAdjust_people_top();
    await getAdjust_people();
    await getAdjust_repeat();
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
                    <button type="submit" class="btn btn-primary" @click="updateAdjust_people()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_repeat" tabindex="-1" aria-labelledby="edit_repeat" aria-hidden="true">
        <div class="modal-dialog  modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">แก้ไขข้อมูล</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="s_num" class=" py-1 mb-0">แก้ไขข้อมูล</label>
                    <textarea rows="7" class="form-control mb-5" v-model="formREdit.title"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="updateAdjust_repeat()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 ">
        <div class="card " id="basic-info">
            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">การประเมินและปรับปรุงการดำเนินการของการฝึกประสบการณ์ภาคสนาม</h5>
                    <label class=" mb-0 ms-0 text-muted">การประเมินและปรับปรุงการดำเนินการของการฝึกประสบการณ์ภาคสนาม
                    </label>
                </div>
            </div>
            <div class="card-body">
                <label class=" mb-0 ms-0 text-muted"> 1. กระบวนการประเมินการฝึกประสบการณ์ภาคสนามจากผู้เกี่ยวข้อง
                </label>
                <div class="row">
                    <div class="col-lg-3 g-4" v-for="item in topic" :key="item.id">
                        <div class="card card-select-doc h-100 menu-detail card-prep-menu"
                            @click="menuDetail_select(item.apt_id)"
                            :class='{ "menu-detail-active": menu_detail === item.apt_id }'>
                            <div class="card-body mt-4 d-flex align-items-start">
                                <div class="">
                                    <p class="mb-0 result-title">{{ item.apt_title }}</p>
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
                                @click="addAdjust_people()">เพิ่มข้อมูล</button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action p-2" v-for="item in adjust" :key="item.id">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label for="" class="fw-normal mb-0 text-muted fs-6">{{ item.apl_title }}
                                </label>
                            </div>
                            <div class="">
                                <i class="bi bi-pen me-3 " @click.prevent="openEditModal(item)"></i>

                                <i class="bi bi-trash3 text-danger " @click="deleteAdjust_people(item.apl_id)"></i>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mt-3" id="basic-info">
            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">การประเมินและปรับปรุงการดำเนินการของการฝึกประสบการณ์ภาคสนาม</h5>
                    <label class=" mb-0 ms-0 text-muted">การประเมินและปรับปรุงการดำเนินการของการฝึกประสบการณ์ภาคสนาม
                    </label>
                </div>
            </div>
            <div class="card-body">
                <label class=" mb-0 ms-0 text-muted"> 2. กระบวนการทบทวนผลการประเมินและการวางแผนปรับปรุง
                </label>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="เพิ่มจุดมุ่งหมายรายวิชา"
                                v-model="formRAdd.title">
                            <button class="btn btn-dark mb-0" type="button" id="button-addon2"
                                @click="addAdjust_repeat()">เพิ่มข้อมูล</button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action p-2" v-for="item in adjustR" :key="item.id">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <label for="" class="fw-normal mb-0 text-muted fs-6">{{ item.adr_title }}
                                </label>
                            </div>
                            <div class="">
                                <i class="bi bi-pen me-3 " @click.prevent="openEditModal_repeat(item)"></i>

                                <i class="bi bi-trash3 text-danger " @click="deleteAdjust_repeat(item.adr_id)"></i>
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
