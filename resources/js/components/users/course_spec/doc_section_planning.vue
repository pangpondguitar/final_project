<script setup>

import { onMounted, ref, computed, watch, reactive } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { defineProps, defineEmits } from 'vue';
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import gsap from 'gsap'
const router = useRouter();
let topic = ref({});
let menu = ref([]);
let week = ref({});
let subject = ref({});
let menu_detail = ref({});
let single_week = ref({});
let plan_top = ref({});
let plan_list = ref({});
let sumhour = ref({});
const editMode = ref(false);
const editing = ref(false);
const editing_list = ref(false);
const page_select = ref(false);
const sunmary = ref({});
menu.value = 1




let formAdd_week = ref({
    week: '',
    hour: ''
});
let formEdit_week = ref({
    id: '',
    week: '',
    hour: ''
});
let formAdd_list = ref({
    title: ''
});
let formEdit_list = ref({
    id: '',
    title: ''
});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const tweened = reactive({
    number: 0
});
const sumhour_num = reactive({
    number: 0
});

let formHours = ref({
    id: '',
    describe: '',
    practice: '',
    self: ''
});

watch([() => formHours.value.describe, () => formHours.value.practice, () => formHours.value.self], ([describe, practice, self]) => {
    const totalHours = Number(describe) + Number(practice) + Number(self);
    gsap.to(sumhour_num, { duration: 0.5, number: totalHours || 0 });
});
const totalHours = computed(() => {

    const describe = parseInt(formHours.value.describe) || 0;
    const practice = parseInt(formHours.value.practice) || 0;
    const self = parseInt(formHours.value.self) || 0;


    sumhour_num.number = describe + practice + self
    return describe + practice + self;
});

const getPlaning_week_hour = async (page = 1) => {
    try {
        let response = await axios.get(`/api/user_get_planWeek_hour/${props.id}/?page=${page}`);
        week.value = response.data.week;
        console.log('week', week.value);
    } catch (error) {
        console.error('Error fetching topic:', error);
    }
};
const addPlaning_week_hour = () => {
    const formData = new FormData();
    formData.append("pw_week", formAdd_week.value.week);
    formData.append("pw_hour", formAdd_week.value.hour);
    axios
        .post(`/api/user_add_planWeek_hour/${props.id}`, formData)
        .then((response) => {
            formAdd_week.value.week = '',
                formAdd_week.value.hour = ''
            getPlaning_week_hour();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const openEditModal = (item) => {
    console.log(item);
    editing.value = true;
    $('#edit_week_hour').modal('show');
    formEdit_week.value = {
        id: item.pw_id,
        week: item.pw_week,
        hour: item.pw_hour,
    }
}
const openEditModal_list = (item) => {
    editing_list.value = true;
    $('#edit_list').modal('show');
    formEdit_list.value = {
        id: item.pwl_id,
        title: item.pwl_title,
    }
}
const updatePlaning_week_hour = () => {
    const formData = new FormData();
    formData.append("pw_id", formEdit_week.value.id);
    formData.append("pw_week", formEdit_week.value.week);
    formData.append("pw_hour", formEdit_week.value.hour);
    axios
        .post(`/api/user_update_planWeek_hour`, formData)
        .then((response) => {
            formEdit_week.value.week = '',
                formEdit_week.value.hour = ''
            formEdit_week.value.hour = ''
            getPlaning_week_hour();
            $('#edit_week_hour').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deletePlaning_week_hour = (id) => {
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
                .get("/api/user_delete_planWeek_hour/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getPlaning_week_hour();
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

const getSubject = async () => {
    try {
        let response = await axios.get(`/api/user_get_subject/${props.id}`);
        subject.value = response.data.subject;
        console.log("subject", subject.value);
    } catch (error) {
        console.error('Error fetching subject:', error);
    }
};
const getPlanning_top = async (doc_type) => {
    try {
        let response = await axios.get(`/api/user_get_planning_top/${doc_type}`);
        topic.value = response.data.topic;
        menu_detail.value = topic.value[0].pt_id;
        console.log("topic", topic.value);
    } catch (error) {
        console.error('Error fetching topic:', error);
    }
};
const getSingle_week = async (id) => {
    try {
        let response = await axios.get(`/api/user_get_singleWeek/${id}`);
        single_week.value = response.data.single_week;
        console.log("single_week", single_week.value);
    } catch (error) {
        console.error('Error fetching single_week:', error);
    }
};

const getPlanning_list = async (pt_id, pw_id) => {
    try {
        let response = await axios.get(`/api/user_get_planning_list/${pt_id}/${pw_id}`);
        plan_list.value = response.data.plan_list;
        console.log('plan_list', plan_list.value);
    } catch (error) {
        console.error('Error fetching topic:', error);
    }
};
const addPlanning_list = (pt_id, pw_id) => {
    console.log(pt_id);
    console.log(pw_id);
    const formData = new FormData();
    formData.append("pwl_title", formAdd_list.value.title);
    axios
        .post(`/api/user_add_planning_list/${pt_id}/${pw_id}`, formData)
        .then((response) => {
            formAdd_list.value.title = ''
            getPlanning_list(pt_id, pw_id);
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const updatePlanning_list = () => {
    const formData = new FormData();
    formData.append("pwl_id", formEdit_list.value.id);
    formData.append("pwl_title", formEdit_list.value.title);
    axios
        .post(`/api/user_update_planning_list`, formData)
        .then((response) => {
            formEdit_list.value.id = '',
                formEdit_list.value.title = ''

            $('#edit_list').modal('hide');
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Update Planing update successfully",
    });
};
const deletePlanning_list = (id) => {
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
                .get("/api/user_delete_planning_list/" + id)
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
const select_week = (doc_type, pw_id) => {
    page_select.value = !page_select.value;
    getPlanning_top(doc_type);
    getSingle_week(pw_id);
    getPlanning_list(menu_detail.value, pw_id);
};
const menuDetail_select = (pt_id, pw_id) => {
    menu_detail.value = pt_id
    getPlanning_list(pt_id, pw_id);
}

const getPlanSum_hour = async () => {
    try {
        let response = await axios.get(`/api/user_get_planning_sum/${props.id}`);
        sumhour.value = response.data.sumhour;
        editMode.value = sumhour.value != null;
        if (editMode.value == true) {
            formHours.value.id = sumhour.value.psh_id
            formHours.value.describe = sumhour.value.psh_describe
            formHours.value.practice = sumhour.value.psh_practice
            formHours.value.self = sumhour.value.psh_self
        }
        console.log(editMode.value);
    } catch (error) {
        console.error('Error fetching topic:', error);
    }
};
const PlanSum_hour_formCheck = async () => {
    try {
        if (editMode.value == true) {
            const formData = new FormData();
            formData.append("psh_id", formHours.value.id);
            formData.append("describe", formHours.value.describe);
            formData.append("practice", formHours.value.practice);
            formData.append("self", formHours.value.self);
            axios
                .post(`/api/user_update_planning_sum`, formData)
                .then((response) => {
                    getPlanSum_hour();
                })
                .catch((error) => { });

            toast.fire({
                icon: "success",
                title: "Update Planing update successfully",
            });
        } else {
            const formData = new FormData();
            formData.append("describe", formHours.value.describe);
            formData.append("practice", formHours.value.practice);
            formData.append("self", formHours.value.self);
            axios
                .post(`/api/user_add_planning_sum/${props.id}`, formData)
                .then((response) => {
                    getPlanSum_hour();
                })
                .catch((error) => { });

            toast.fire({
                icon: "success",
                title: "Week hour add successfully",
            });
        }
    } catch (error) {
        console.error('Error submitting data:', error);
    }
};


onMounted(async () => {
    await getPlaning_week_hour();
    await getSubject();
    await getPlanSum_hour();

});
</script>
<template>
    <div class="modal fade" id="edit_week_hour" tabindex="-1" aria-labelledby="edit_week_hour" aria-hidden="true">
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
                            v-model="formEdit_week.week">
                        <label for="s_name" class="fs-6 py-1 mb-0">จำนวนชั่วโมง</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_name"
                            v-model="formEdit_week.hour">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="updatePlaning_week_hour()">บันทึกข้อมูล</button>
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
                    <div class="p-1">
                        <label for="s_num" class="fs-6 py-1 mb-0">สัปดาห์ที่สอน</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_num"
                            v-model="formEdit_list.title">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" @click="updatePlanning_list()">บันทึกข้อมูล</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 ">

        <div class="card " id="basic-info" v-if="page_select == false">

            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">แผนการสอน </h5>
                        <label class=" mb-0 ms-0 text-muted">สัปดาห์ที่(จำนวนชั่วโมง)
                        </label>
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-5">

                        <input type="text" class="form-control" placeholder="สัปดาห์ที่" v-model="formAdd_week.week">
                    </div>
                    <div class="col-4">

                        <input type="text" class="form-control" placeholder="จำนวนชั่วโมง" v-model="formAdd_week.hour">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-dark" @click="addPlaning_week_hour()">เพิ่มข้อมูล</button>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action p-1" v-for="item in week.data" :key="item.id">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>

                                <label for="" class="fw-normal mb-0 text-muted fs-6">สัปดาห์ที่ {{ item.pw_week }}
                                </label>
                                <br>
                                <div>
                                    <label for="" class="me-2">จำนวนชั่วโมง</label>
                                    <span for="" class=" text-success fw-bold">{{ item.pw_hour }}</span>
                                </div>


                            </div>
                            <div class="">
                                <i class="bi bi-pen btn btn-light btn-sm px-3 mb-0"
                                    @click.prevent="openEditModal(item)"></i>

                                <i class="bi bi-trash3 text-white mx-2 btn btn-danger btn-sm px-3 mb-0"
                                    @click="deletePlaning_week_hour(item.pw_id)"></i>
                                <i class="bi bi-box-arrow-right  btn btn-dark btn-sm px-3 mb-0"
                                    @click="select_week(subject.doc_type, item.pw_id)"></i>

                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="container d-flex justify-content-end">
                <Bootstrap5Pagination :data="week" @pagination-change-page="getPlaning_week_hour" />
            </div>
        </div>

        <div class="card  mt-3" id="basic-info" v-if="page_select == false">
            <div class="card-header pb-4">

                <h5 class="mb-0">สรุปจํานวนชั่วโมงที่ใช้ต่อภาคการศึกษา</h5>
                <label class=" mb-0 ms-0 text-muted">สรุปจํานวนชั่วโมงที่ใช้ต่อภาคการศึกษา
                </label>

            </div>

            <div class="card-body">
                <div class="row ">
                    <div class="col-lg-6">
                        <div class="d-flex">
                            <h2>{{ sumhour_num.number.toFixed(0) }}</h2>
                            <label class="text-secondary"> ชั่วโมง</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="s_num" class=" py-1 mb-0">ภาคทฤษฎีการบรรยาย</label>
                        <input type="text" class="form-control" placeholder="ภาคทฤษฎีการบรรยาย"
                            v-model="formHours.describe">
                    </div>
                    <div class="col-lg-4">
                        <label for="s_num" class=" py-1 mb-0">ภาคปฏิบัติ(การฝึกปฏิบัติ/ภาคสนาม/การฝึกงาน)</label>
                        <input type="text" class="form-control" placeholder="ภาคปฏิบัติ" v-model="formHours.practice">
                    </div>
                    <div class="col-lg-4">
                        <label for="s_num" class=" py-1 mb-0">การศึกษาด้วยตนเอง</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" v-model="formHours.self">
                    </div>
                </div>

                <button class="btn btn-dark mt-3" @click="PlanSum_hour_formCheck()">บันทึกข้อมูล</button>
            </div>
        </div>
        <div class="card " id="basic-info" v-if="page_select == true">
            <div class="card-header pb-4">
                <div class="d-flex">
                    <div>
                        <i class="bi bi-box-arrow-left fs-4 me-3" @click="page_select = !page_select"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">เพิ่มข้อมูลแผนการสอนแต่ละหัวข้อ</h5>
                        <label class=" mb-0 ms-0 text-muted">เพิ่มข้อมูลการสอนแต่ละหัวข้อในแต่ละสัปดาห์
                        </label>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex">
                            <h6 class="me-3">สัปดาห์ที่ : {{ single_week.pw_week }}</h6>
                            <h6 class="text-danger">จำนวนชั่วโมง : {{ single_week.pw_hour }}</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 g-4" v-for="item in topic" :key="item.id">
                        <div class="card card-select-doc h-100 menu-detail"
                            @click="menuDetail_select(item.pt_id, single_week.pw_id)"
                            :class='{ "menu-detail-active": menu_detail === item.pt_id }'>
                            <div class="card-body mt-4 d-flex align-items-start">
                                <div class="">
                                    <p class="mb-0 result-title">{{ item.pt_title }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 mt-3 ">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="เพิ่มจุดมุ่งหมายรายวิชา"
                                aria-label="Recipient's username" aria-describedby="button-addon2"
                                v-model="formAdd_list.title">
                            <button class="btn btn-dark mb-0" type="button" id="button-addon2"
                                @click="addPlanning_list(menu_detail, single_week.pw_id)">เพิ่มข้อมูล</button>
                        </div>
                    </div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item list-group-item-action" v-for="item in plan_list" :key="item.id">

                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 for="" class="fw-normal mb-0 text-muted"> {{ item.pwl_title }}</h6>
                            </div>
                            <div>
                                <i class="bi bi-pen me-3" @click="openEditModal_list(item)"></i>
                                <i class="bi bi-trash3 text-danger" @click="deletePlanning_list(item.pwl_id)"></i>
                            </div>
                        </div>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</template>


<style></style>
