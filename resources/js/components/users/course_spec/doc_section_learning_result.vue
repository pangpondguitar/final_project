<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { defineProps, defineEmits } from "vue";
const router = useRouter();
let topic = ref({});
let menu_detail = ref({});
let result_list = ref([]);
let result_detail = ref([]);
let objective = ref({});
let result_detail_all = ref([]);
let remark = ref([]);
let result_list_detailId = ref({});
let item = ref([]);
let checkedItems = ref([]);

const editing = ref(false);
const editing_detail = ref(false);
const editing_obj = ref(false);
const modalremark = ref(false);
let formAdd = ref({
    title: "",
});
let formEdit = ref({
    id: "",
    title: "",
});

let formAdd_detail = ref({
    title: "",
});
let formEdit_detail = ref({
    id: "",
    title: "",
});

let formAdd_Obj = ref({
    title: "",
});
let formEdit_Obj = ref({
    id: "",
    title: "",
});
let form_remark = ref({
    id: "",
    title: "",
});

const openEditModal = (item) => {
    console.log(item);
    editing.value = true;
    $("#edit").modal("show");
    formEdit.value = {
        id: item.lrl_id,
        title: item.lrl_title,
    };
};
const openRemarkModal = (item) => {
    form_remark.value.id = item.lrl_id;
    form_remark.value.title = item.lrl_title;
    getLearnResult_Remark(item.lrl_id);
    getLearnResult_Detail_All();
    modalremark.value = true;
    $("#ModalRemark").modal("show");
};

const openEditModal_detail = (item) => {
    console.log(item);
    editing.value = true;
    $("#edit_detail").modal("show");
    formEdit_detail.value = {
        id: item.lrd_id,
        title: item.lrd_title,
    };
};
const openEditModal_Objective = (item) => {
    editing_obj.value = true;
    $("#edit_objective").modal("show");
    formEdit_Obj.value = {
        id: item.obj_id,
        title: item.obj_title,
    };
};
menu_detail.value = 1;

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const getToppic_learnResult = async () => {
    try {
        let response = await axios.get(`/api/user_get_top_result/${props.id}`);
        topic.value = response.data.topic;
        menu_detail.value = topic.value[0].tlr_id;
        console.log("topic", topic.value);
    } catch (error) {
        console.error("Error fetching topic:", error);
    }
};
const getLearnResult_list = async () => {
    try {
        let response = await axios.get(
            `/api/user_get_Lresult_list/${props.id}`
        );
        result_list.value = response.data.result_list;
        console.log("result_list", result_list.value);
    } catch (error) {
        console.error("Error fetching result_list:", error);
    }
};

const getLearnResult_Remark = async (id) => {
    try {
        let response = await axios.get(`/api/user_get_result_remark/${id}`);
        remark.value = response.data.remark;
        console.log("result_remark", remark.value);
    } catch (error) {
        console.error("Error fetching result_list:", error);
    }
};
const getLearnResult_Detail_All = async () => {
    try {
        let response = await axios.get(
            `/api/user_get_result_detail_All/${props.id}`
        );
        checkedItems.value = [];
        result_detail_all = response.data.result_detail;
        console.log("result_detail", result_detail_all);
        result_detail_all.forEach((item) => {
            if (Array.isArray(remark.value) && remark.value.length > 0) {
                const foundInMark = remark.value.some(
                    (markItem) => item.lrd_id.toString() === markItem.lrd_id
                );
                if (foundInMark) {
                    item.checked = true;
                    checkedItems.value.push(item.lrd_id);
                    console.log("Pushed item ID:", item.lrd_id);
                } else {
                    item.checked = false; // กำหนดให้ item.checked เป็น false เมื่อไม่พบใน remark
                }
            } else {
                item.checked = false;
                console.log("remark is not an array or it's empty");
            }
        });
    } catch (error) {
        console.error("Error fetching result_list:", error);
    }
};
const updateCheckedItems = () => {
    console.log("Checked Items:", checkedItems.value);
};
const menuDetail_select = (id) => {
    menu_detail.value = id;
    getLearnResult_detail();
};
const teaching_sub = (id) => {
    router.push("/admin/teaching/teaching_sub/" + id);
};

const delete_result_list = (id) => {
    Swal.fire({
        title: "ยืนยันลบข้อมูลจุดมุ่งหมายรายวิชา",
        text: "ยืนยันลบข้อมูล",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/user_delete_Lresult_list/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getLearnResult_list();
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
const add_result_list = () => {
    const formData = new FormData();
    formData.append("lrl_title", formAdd.value.title);
    axios
        .post(`/api/user_add_Lresult_list/${props.id}`, formData)
        .then((response) => {
            (formAdd.value.title = ""), getLearnResult_list();
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result add successfully",
    });
};
const update_result_list = () => {
    const formData = new FormData();
    formData.append("lrl_id", formEdit.value.id);
    formData.append("lrl_title", formEdit.value.title);
    axios
        .post(`/api/user_update_Lresult_list`, formData)
        .then((response) => {
            (formEdit.value.id = ""), (formEdit.value.title = "");
            getLearnResult_list();
            $("#edit").modal("hide");
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result update successfully",
    });
};

const getLearnResult_detail = async () => {
    try {
        let response = await axios.get(
            `/api/user_get_Lresult_detail/${props.id}/${menu_detail.value}`
        );
        result_detail.value = response.data.result_detail;
        console.log("result_detail", result_detail.value);
    } catch (error) {
        console.error("Error fetching result_detail:", error);
    }
};
const add_result_detail = () => {
    const formData = new FormData();
    formData.append("lrd_title", formAdd_detail.value.title);
    formData.append("tlr_id", menu_detail.value);
    axios
        .post(`/api/user_add_Lresult_detail/${props.id}`, formData)
        .then((response) => {
            (formAdd_detail.value.title = ""), getLearnResult_detail();
            getLearnResult_Detail_All();
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result add successfully",
    });
};
const add_result_remark = () => {
    const formData = new FormData();
    checkedItems.value.forEach((item) => {
        formData.append("lrd_id[]", item);
    });
    formData.append("lrl_id", form_remark.value.id);
    axios
        .post(`/api/user_update_result_remark`, formData)
        .then((response) => {
            form_remark.value.id = "";
            $("#edit_objective").modal("hide");
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result add successfully",
    });
};

const update_result_detail = () => {
    const formData = new FormData();
    formData.append("lrd_id", formEdit_detail.value.id);
    formData.append("lrd_title", formEdit_detail.value.title);
    axios
        .post(`/api/user_update_Lresult_detail`, formData)
        .then((response) => {
            (formEdit_detail.value.id = ""), (formEdit_detail.value.title = "");
            getLearnResult_detail();
            $("#edit_detail").modal("hide");
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result update successfully",
    });
};
const delete_result_detail = (id) => {
    Swal.fire({
        title: "ยืนยันลบข้อมูลรายละเอียด",
        text: "ยืนยันลบข้อมูล",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/user_delete_Lresult_detail/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getLearnResult_detail();
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
const get_Objective = async () => {
    try {
        let response = await axios.get(`/api/user_get_objective/${props.id}`);
        objective.value = response.data.objective;
        console.log("objective", objective.value);
    } catch (error) {
        console.error("Error fetching objective:", error);
    }
};
const add_Objective = () => {
    const formData = new FormData();
    formData.append("title", formAdd_Obj.value.title);
    axios
        .post(`/api/user_add_objective/${props.id}`, formData)
        .then((response) => {
            (formAdd_Obj.value.title = ""), get_Objective();
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result add successfully",
    });
};
const update_Objective = () => {
    const formData = new FormData();
    formData.append("id", formEdit_Obj.value.id);
    formData.append("title", formEdit_Obj.value.title);
    axios
        .post(`/api/user_update_objective`, formData)
        .then((response) => {
            (formEdit_Obj.value.id = ""), (formEdit_Obj.value.title = "");
            get_Objective();
            $("#edit_objective").modal("hide");
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "List Result update successfully",
    });
};
const delete_Objective = (id) => {
    Swal.fire({
        title: "ยืนยันลบข้อมูล",
        text: "ยืนยันลบข้อมูล",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/user_delete_objective/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    get_Objective();
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

onMounted(async () => {
    await getToppic_learnResult();
    await getLearnResult_list();
    await getLearnResult_detail();
    await getLearnResult_Detail_All();
    await get_Objective();
});
</script>

<template>
    <div class="col-lg-9">
        <div
            class="modal fade"
            id="edit"
            tabindex="-1"
            aria-labelledby="edit"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">
                            แก้ไขจุดมุ่งหมายของรายวิชา
                        </h2>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-1">
                            <label for="title" class="fs-6 py-1 mb-0"
                                >จุดมุ่งหมายของรายวิชา</label
                            >
                            <textarea
                                class="form-control"
                                rows="5"
                                v-model="formEdit.title"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            ปิด
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="update_result_list()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="edit_detail"
            tabindex="-1"
            aria-labelledby="edit_detail"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">
                            แก้ไขจุดมุ่งหมายของรายวิชา
                        </h2>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-1">
                            <label for="title" class="fs-6 py-1 mb-0"
                                >จุดมุ่งหมายของรายวิชา</label
                            >
                            <textarea
                                class="form-control"
                                rows="5"
                                v-model="formEdit_detail.title"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            ปิด
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="update_result_detail()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="edit_objective"
            tabindex="-1"
            aria-labelledby="edit_objective"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel">
                            แก้ไขวัตถุประสงค์ของรายวิชา
                        </h2>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-1">
                            <label for="title" class="fs-6 py-1 mb-0"
                                >วัตถุประสงค์ของรายวิชา</label
                            >
                            <textarea
                                class="form-control"
                                rows="5"
                                v-model="formEdit_Obj.title"
                            ></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            ปิด
                        </button>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="update_Objective()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="ModalRemark"
            tabindex="-1"
            aria-labelledby="ModalRemark"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="row">
                            <div class="col-lg-7">
                                <h1
                                    class="modal-title fs-5 fw-normal p-3"
                                    id="ModalRemark"
                                >
                                    {{ form_remark.title }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body py-0 px-0">
                        <ul class="list-group list-group-flush">
                            <li
                                class="list-group-item"
                                v-for="item in result_detail_all"
                                :key="item.id"
                            >
                                <div class="row px-3">
                                    <div class="col-lg-11">
                                        <div class="d-flex">
                                            <div></div>
                                            <div>
                                                <label
                                                    for=""
                                                    class="text-sm fw-normal text-muted"
                                                >
                                                    {{ item.num }}
                                                    {{ item.title }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-lg-1 d-flex align-items-center"
                                    >
                                        <div class="d-flex align-items-center">
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    :value="item.lrd_id"
                                                    v-model="checkedItems"
                                                    @change="updateCheckedItems"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-light text-sm fw-normal text-dark"
                            data-bs-dismiss="modal"
                        >
                            ยกเลิก
                        </button>
                        <button
                            type="button"
                            class="btn bg-gradient-success fw-normal text-sm"
                            @click="add_result_remark()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="basic-info">
            <div class="card-header pb-0">
                <h5 class="mb-0">ผลลัพธ์การเรียนรู้รายวิชา</h5>
                <label class="mb-0 ms-0 text-muted"
                    >จุดมุ่งหมายของรายวิชา
                </label>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="เพิ่มจุดมุ่งหมายรายวิชา"
                                aria-label="Recipient's username"
                                aria-describedby="button-addon2"
                                v-model="formAdd.title"
                            />
                            <button
                                class="btn btn-dark mb-0"
                                type="button"
                                id="button-addon2"
                                @click="add_result_list()"
                            >
                                เพิ่มข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush list-group-numbered">
                    <li
                        class="list-group-item d-flex justify-content-between"
                        v-for="item in result_list"
                        :key="item.id"
                    >
                        <div
                            class="ms-2 me-auto w-50 d-flex align-items-center"
                        >
                            <h6 class="fw-normal text-muted text-sm">
                                {{ item.lrl_title }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <i
                                class="bi bi-bookmark-star-fill me-3 text-success fs-5"
                                @click.prevent="openRemarkModal(item)"
                            ></i>
                            <i
                                class="bi bi-pen me-3"
                                @click.prevent="openEditModal(item)"
                            ></i>
                            <i
                                class="bi bi-trash3 text-danger"
                                @click="delete_result_list(item.lrl_id)"
                            ></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-3" id="basic-info">
            <div class="card-header">
                <h5 class="mb-0">รายละเอียดผลลัพธ์การเรียนรู้</h5>
                <label class="mb-0 ms-0 text-muted"
                    >รายละเอียดผลลัพธ์การเรียนรู้แต่ละด้านตาม
                    มาตรฐานคุณวุฒิระดับอุดมศึกษา ประกอบด้วย
                </label>
            </div>

            <div class="card-body">
                <div class="row">
                    <div
                        class="col-lg-3 g-4"
                        v-for="item in topic"
                        :key="item.id"
                    >
                        <div
                            class="card card-select-doc h-100 menu-detail"
                            @click="menuDetail_select(item.tlr_id)"
                            :class="{
                                'menu-detail-active':
                                    menu_detail === item.tlr_id,
                            }"
                        >
                            <div
                                class="card-body mt-4 d-flex align-items-start"
                            >
                                <div class="">
                                    <p class="mb-0 result-title">
                                        {{ item.tlr_title }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <h6 class="mt-4">เพิ่มหัวข้อ1</h6>
                            <div class="mb-3">
                                <textarea
                                    class="form-control"
                                    id="exampleFormControlTextarea1"
                                    rows="4"
                                    v-model="formAdd_detail.title"
                                ></textarea>
                                <button
                                    class="btn btn-dark mt-2"
                                    @click="add_result_detail()"
                                >
                                    เพิ่มข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush list-group-numbered">
                    <li
                        class="list-group-item d-flex justify-content-between"
                        v-for="item in result_detail"
                        :key="item.id"
                    >
                        <div
                            class="ms-2 me-auto w-50 d-flex align-items-center"
                        >
                            <h6 class="fw-normal text-muted">
                                {{ item.lrd_title }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <i
                                class="bi bi-pen me-3"
                                @click.prevent="openEditModal_detail(item)"
                            ></i>
                            <i
                                class="bi bi-trash3 text-danger"
                                @click="delete_result_detail(item.lrd_id)"
                            ></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mt-3" id="basic-info">
            <div class="card-header pb-0">
                <h5 class="mb-0">วัตถุประสงค์</h5>
                <label class="mb-0 ms-0 text-muted">วัตถุประสงค์รายวิชา </label>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="เพิ่มจุดมุ่งหมายรายวิชา"
                                aria-label="Recipient's username"
                                aria-describedby="button-addon2"
                                v-model="formAdd_Obj.title"
                            />
                            <button
                                class="btn btn-dark mb-0"
                                type="button"
                                id="button-addon2"
                                @click="add_Objective()"
                            >
                                เพิ่มข้อมูล
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush list-group-numbered">
                    <li
                        class="list-group-item d-flex justify-content-between"
                        v-for="item in objective"
                        :key="item.id"
                    >
                        <div
                            class="ms-2 me-auto w-50 d-flex align-items-center"
                        >
                            <h6 class="fw-normal text-muted">
                                {{ item.obj_title }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <i
                                class="bi bi-pen me-3"
                                @click="openEditModal_Objective(item)"
                            ></i>
                            <i
                                class="bi bi-trash3 text-danger"
                                @click="delete_Objective(item.obj_id)"
                            ></i>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style>
.menu-detail:hover {
    background-color: #e4e4e4;
    transition: 0.2s;
    transform: scale(1.05);
}

.menu-detail {
    transition: 0.3s;
    font-size: 18px !important;
    border-radius: 22px;
}

.menu-detail-active {
    background: linear-gradient(135deg, #17ead9 0%, #6078ea 100%);
    font-weight: 600 !important;
    border-radius: 22px;
    color: #fff;
}

.menu-detail .result-title {
    font-size: 17px !important;
}
</style>
