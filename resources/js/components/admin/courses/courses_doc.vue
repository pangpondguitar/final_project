<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { Bootstrap5Pagination } from "laravel-vue-pagination";
let subjects = ref({});
let sub_menu = ref({});
let topic = ref({});

sub_menu.value = 1
let form = ref({
    title: ''
})
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_subjects = async (page = 1) => {
    try {
        let response = await axios.get(`/api/admin_get_courses_subjects/${props.id}/?page=${page}`);
        subjects.value = response.data.subjects;
    } catch (error) {
        console.error("Error fetching subjects:", error);
    }
};
const get_topic_result = async () => {
    try {
        let response = await axios.get(`/api/admin_get_topic_result/${props.id}`);
        topic.value = response.data.topic;
    } catch (error) {
        console.error("Error fetching topic:", error);
    }
};


const change_doctype = (id, doc_type) => {
    const formData = new FormData();
    formData.append("doc_type", doc_type);
    axios
        .post(`/api/admin_edit_subject_doc/${id}`, formData)
        .then((response) => {

        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject Edit successfully",
    });
};

const delete_topic_result = (id, title) => {
    Swal.fire({
        title: "ยืนยันหัวข้อนี้",
        text: title,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/admin_delete_topic_result/" + id)
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
const saveTopic = (doc_type) => {
    const formData = new FormData();
    formData.append("doc_type", doc_type);
    formData.append("title", form.value.title);

    axios
        .post(`/api/admin_add_topic_result/${props.id}`, formData)
        .then((response) => {
            form.title = ''
            get_topic_result();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject Edit successfully",
    });
};


const subMenu = (id) => {
    sub_menu.value = id
}
onMounted(async () => {
    await get_subjects();
    await get_topic_result();

});

</script>
<template>
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">จัดการข้อมูล มคอ.</h5>
                        <p class="text-sm">จัดการข้อมูลการจัดทำ มคอ.</p>
                    </div>
                    <div class="ms-5">
                        <button class="btn btn-outline-danger me-2 active " @click="subMenu(1)"><i
                                class="bi bi-journal-bookmark-fill"></i></button>
                        <button class="btn btn-outline-dark" @click="subMenu(2)"><i class="bi bi-gear-fill"></i></button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12" v-if="sub_menu == 1">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center th1">
                                        #</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center th2">
                                        รหัสวิชา</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        ชื่อวิชา</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        Function</th>

                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="item in subjects.data" :key="item.id">
                                    <td>
                                        <div class="form-check ms-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="flexCheckDefault" />
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-center fw-normal">{{ item.s_num }}</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 fw-normal">{{ item.s_name }}</h6>
                                                <h6 class="text-xs text-secondary mb-0">{{ item.s_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="radio"
                                                    :name="'flexRadioDefault' + item.s_id" id="flexRadioDefault1"
                                                    v-model="item.doc_type" value="1" @click="change_doctype(item.s_id, 1)">
                                                <label class="form-check-label fw-bold" for="flexRadioDefault1">
                                                    มคอ.3
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    :name="'flexRadioDefault' + item.s_id" id="flexRadioDefault2"
                                                    v-model="item.doc_type" value="2" @click="change_doctype(item.s_id, 2)">
                                                <label class="form-check-label text-danger fw-bold" for="flexRadioDefault2">
                                                    มคอ.4
                                                </label>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="container ">
                        <Bootstrap5Pagination :data="subjects" @pagination-change-page="get_subjects
                            " class="float-end mt-3" />
                    </div>
                </div>
                <div class="card-body" v-if="sub_menu == 2">
                    <div class="col-lg-12 p-1">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="card  menu-doc-active ">
                                    <div class="card-body">
                                        <div class="d-flex mt-3">
                                            <div>
                                                <h5 class="mb-0 title">มคอ.3
                                                </h5>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 ">
                                <div class="card card-setting">
                                    <div class="card-body">
                                        <div class="d-flex mt-3">
                                            <div>
                                                <h5 class="mb-0">มคอ.4
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="card card-setting">
                                    <div class="card-header pb-0 p-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="mb-0">หัวข้อผลลัพธ์การเรียนรู้รายวิชา</h6>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="d-flex justify-content-between">
                                            <div class="">
                                                <input type="text" class="form-control form-input-topic" id=""
                                                    v-model="form.title">
                                            </div>
                                            <div>
                                                <button class="btn btn-dark" @click="saveTopic(1, 1)">เพิ่มหัวข้อ</button>
                                            </div>
                                        </div>
                                        <ul class="list-group" v-for="item in topic" :key="item.id">
                                            <li
                                                class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                        <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" class="mt-1">
                                                            <title>spaceship</title>
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <g transform="translate(-1720.000000, -592.000000)"
                                                                    fill="#FFFFFF" fill-rule="nonzero">
                                                                    <g transform="translate(1716.000000, 291.000000)">
                                                                        <g transform="translate(4.000000, 301.000000)">
                                                                            <path
                                                                                d="M39.3,0.706666667 C38.9660984,0.370464027 38.5048767,0.192278529 38.0316667,0.216666667 C14.6516667,1.43666667 6.015,22.2633333 5.93166667,22.4733333 C5.68236407,23.0926189 5.82664679,23.8009159 6.29833333,24.2733333 L15.7266667,33.7016667 C16.2013871,34.1756798 16.9140329,34.3188658 17.535,34.065 C17.7433333,33.98 38.4583333,25.2466667 39.7816667,1.97666667 C39.8087196,1.50414529 39.6335979,1.04240574 39.3,0.706666667 Z M25.69,19.0233333 C24.7367525,19.9768687 23.3029475,20.2622391 22.0572426,19.7463614 C20.8115377,19.2304837 19.9992882,18.0149658 19.9992882,16.6666667 C19.9992882,15.3183676 20.8115377,14.1028496 22.0572426,13.5869719 C23.3029475,13.0710943 24.7367525,13.3564646 25.69,14.31 C26.9912731,15.6116662 26.9912731,17.7216672 25.69,19.0233333 L25.69,19.0233333 Z">
                                                                            </path>
                                                                            <path
                                                                                d="M1.855,31.4066667 C3.05106558,30.2024182 4.79973884,29.7296005 6.43969145,30.1670277 C8.07964407,30.6044549 9.36054508,31.8853559 9.7979723,33.5253085 C10.2353995,35.1652612 9.76258177,36.9139344 8.55833333,38.11 C6.70666667,39.9616667 0,40 0,40 C0,40 0,33.2566667 1.855,31.4066667 Z">
                                                                            </path>
                                                                            <path
                                                                                d="M17.2616667,3.90166667 C12.4943643,3.07192755 7.62174065,4.61673894 4.20333333,8.04166667 C3.31200265,8.94126033 2.53706177,9.94913142 1.89666667,11.0416667 C1.5109569,11.6966059 1.61721591,12.5295394 2.155,13.0666667 L5.47,16.3833333 C8.55036617,11.4946947 12.5559074,7.25476565 17.2616667,3.90166667 L17.2616667,3.90166667 Z"
                                                                                opacity="0.598539807"></path>
                                                                            <path
                                                                                d="M36.0983333,22.7383333 C36.9280725,27.5056357 35.3832611,32.3782594 31.9583333,35.7966667 C31.0587397,36.6879974 30.0508686,37.4629382 28.9583333,38.1033333 C28.3033941,38.4890431 27.4704606,38.3827841 26.9333333,37.845 L23.6166667,34.53 C28.5053053,31.4496338 32.7452344,27.4440926 36.0983333,22.7383333 L36.0983333,22.7383333 Z"
                                                                                opacity="0.598539807"></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-1 text-dark text-sm">{{ item.tlr_title }}</h6>
                                                        <span class="text-xs">250 in stock, <span
                                                                class="font-weight-bold">346+ sold</span></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <button @click="
                                                        delete_topic_result(
                                                            item.tlr_id,
                                                            item.tlr_title
                                                        )
                                                        " type="button"
                                                        class="btn btn-reddit btn-icon-only rounded-circle mb-0">
                                                        <span class="btn-inner--icon"><i class="bi bi-trash3"></i></span>
                                                    </button>
                                                </div>
                                            </li>

                                        </ul>
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


<style>
.th1 {
    width: 2% !important;
}

.th2 {
    width: 10% !important;
}

.card-setting {
    box-shadow: none;
    border: solid #f4f4f4 1px;
}

.menu-doc-active {
    box-shadow: none;
    border: solid #cacaca 2px;
    font-weight: 600 !important;
}

.menu-doc-active {
    box-shadow: none;
    color: #fff;
    border: none;
    /* background-color: #faf0ff; */
    border: 1px dashed #959595;
}

.menu-doc-active .title {
    color: #494949;
}

.form-input-topic {
    width: 200px !important;
}
</style>
