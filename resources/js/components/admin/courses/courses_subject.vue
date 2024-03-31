<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
let subjects = ref([]);
let course = ref([]);
const editing = ref(false);

let form = ref({
    s_id: "",
    s_num: "",
    s_name: "",
    s_name2: "",
    s_credit: "",
    doc_type: "",
});

let formAdd = ref({
    s_num: "",
    s_name: "",
    s_name2: "",
    s_credit: "",
    doc_type: 1,
});
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_subjects = async (page = 1) => {
    try {
        let response = await axios.get(
            `/api/admin_get_courses_subjects/${props.id}/?page=${page}`
        );
        subjects.value = response.data.subjects;
    } catch (error) {
        console.error("Error fetching subjects:", error);
    }
};

const openEditModal = (item) => {
    console.log(item);
    editing.value = true;
    $("#edit").modal("show");
    form.value = {
        s_id: item.s_id,
        s_num: item.s_num,
        s_name: item.s_name,
        s_name2: item.s_name2,
        s_credit: item.s_credit,
        doc_type: item.doc_type,
    };
};

const saveSubject = () => {
    const formData = new FormData();
    formData.append("s_num", formAdd.value.s_num);
    formData.append("s_name", formAdd.value.s_name);
    formData.append("s_name2", formAdd.value.s_name2);
    formData.append("s_credit", formAdd.value.s_credit);
    formData.append("doc_type", formAdd.value.doc_type);
    axios
        .post(`/api/admin_add_subject/${props.id}`, formData)
        .then((response) => {
            (formAdd.value.s_num = ""),
                (formAdd.value.s_name = ""),
                (formAdd.value.s_name2 = ""),
                (formAdd.value.s_credit = ""),
                (formAdd.value.doc_type = "");
            get_subjects();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};
const editSubject = () => {
    const formData = new FormData();
    formData.append("s_id", form.value.s_id);
    formData.append("s_num", form.value.s_num);
    formData.append("s_name", form.value.s_name);
    formData.append("s_name2", form.value.s_name2);
    formData.append("s_credit", form.value.s_credit);
    formData.append("doc_type", form.value.doc_type);
    axios
        .post(`/api/admin_update_subject/`, formData)
        .then((response) => {
            (form.value.s_id = ""),
                (form.value.s_num = ""),
                (form.value.s_name = ""),
                (form.value.s_name2 = ""),
                (form.value.s_credit = ""),
                (form.value.doc_type = "");
            get_subjects();
            $("#edit").modal("hide");
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};

const delete_subject = (id, s_name) => {
    Swal.fire({
        title: "ยืนยันลบอาจารย์ผู้สอน",
        text: s_name,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/admin_delete_subject/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    get_subjects();
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
    await get_subjects();
});
</script>
<template>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">
                        เพิ่มรายวิชา
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-1">
                        <label for="s_num" class="fs-6 py-1 mb-0">รหัสวิชา</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_num"
                            v-model="formAdd.s_num" />
                        <label for="s_name" class="fs-6 py-1 mb-0">ชื่อวิชา(ภาษาไทย)</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_name"
                            v-model="formAdd.s_name" />
                        <label for="s_name" class="fs-6 py-1 mb-0">ชื่อวิชา(ภาษาอังกฤษ)</label>
                        <input type="text" class="form-control" placeholder="please enter subject name" id="s_name"
                            v-model="formAdd.s_name2" />
                        <label for="s_name" class="fs-6 py-1 mb-0">จำนวนหน่วยกิต</label>
                        <input type="text" class="form-control" placeholder="ป้อนจำนวนหน่วยกิต" id="s_name"
                            v-model="formAdd.s_credit" />
                        <div class="d-flex justify-content-start mt-3">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="flexRadioDefault2"
                                    id="flexRadioDefault5" value="1" checked v-model="formAdd.doc_type" />
                                <label class="form-check-label fw-bold" for="flexRadioDefault5">
                                    มคอ.3
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault2"
                                    id="flexRadioDefault6" v-model="formAdd.doc_type" value="2" />
                                <label class="form-check-label fw-bold" for="flexRadioDefault6">
                                    มคอ.4
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        ปิด
                    </button>
                    <button type="submit" class="btn btn-primary" @click="saveSubject()">
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">รายวิชาในหลักสูตร</h5>
                        <p class="text-sm">รายวิชาทั้งหมด</p>
                    </div>
                    <div>
                        <a href="" class="btn bg-gradient-dark fw-normal text-sm" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">เพิ่มรายวิชา +
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center mb-0 table table-hover">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-sm fw-normal opacity-7 text-center">
                                รหัสวิชา
                            </th>
                            <th class="text-uppercase text-secondary text-sm fw-normal opacity-7">
                                ชื่อวิชา
                            </th>
                            <th class="text-uppercase text-secondary text-sm fw-normal opacity-7 text-center">
                                ควบคุม
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in subjects.data" :key="item.id">
                            <td class="align-middle text-center text-sm">
                                <h6 class="mb-0 fw-light text-sm  text-muted">
                                    {{ item.s_num }}
                                        </h6>
                            </td>
                            <td>
                                <div class="d-flex px-3 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 fw-light text-sm fw-bold">
                                            {{ item.s_name }}
                                        </h6>
                                        <h6 class="text-xs text-secondary mb-0 fw-normal">
                                            {{ item.s_name2 }}
                                        </h6>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle text-center">
                                <!-- <a href="javascript:;" class="text-secondary font-weight-bold ms-3" data-toggle="tooltip"
                                    data-original-title="Edit user" data-bs-toggle="modal" data-bs-target="#edit">
                                    <i class="bi bi-pen"></i>
                                </a> -->
                                <a @click.prevent="openEditModal(item)">
                                    <i class="bi bi-pen"></i>
                                </a>
                                <a class="text-danger font-weight-bold ms-4" data-toggle="tooltip" @click="
                                delete_subject(item.s_id, item.s_name)
                                ">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="container">
                    <Bootstrap5Pagination :data="subjects" @pagination-change-page="get_subjects"
                        class="float-end mt-3" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit" aria-hidden="true" @hidden="onModalHidden">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="exampleModalLabel">
                        แก้ไขข้อมูลรายวิชา
                    </h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-1">
                        <label for="s_num" class="fs-6 py-1 mb-0">รหัสวิชา</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_num"
                            v-model="form.s_num" />
                        <label for="s_name" class="fs-6 py-1 mb-0">ชื่อวิชา(ภาษาไทย)</label>
                        <input type="text" class="form-control" placeholder="ป้อนชื่อรายวิชา" id="s_name"
                            v-model="form.s_name" />
                        <label for="s_name" class="fs-6 py-1 mb-0">ชื่อวิชา(ภาษาอังกฤษ)</label>
                        <input type="text" class="form-control" placeholder="please enter subject name" id="s_name"
                            v-model="form.s_name2" />
                        <label for="s_name" class="fs-6 py-1 mb-0">จำนวนหน่วยกิต</label>
                        <input type="text" class="form-control" placeholder="ป้อนจำนวนหน่วยกิต" id="s_name"
                            v-model="form.s_credit" />
                        <div class="d-flex justify-content-start mt-3">
                            <div class="form-check me-2">
                                <input class="form-check-input" type="radio" name="flexRadioDefault1"
                                    id="flexRadioDefault3" value="1" v-model="form.doc_type"
                                    :checked="form.doc_type === '1'" />
                                <label class="form-check-label fw-bold" for="flexRadioDefault3">
                                    มคอ.3
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault1"
                                    id="flexRadioDefault4" value="2" v-model="form.doc_type" />
                                <label class="form-check-label fw-bold" for="flexRadioDefault4"
                                    :checked="form.doc_type === '2'">
                                    มคอ.4
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        ปิด
                    </button>
                    <button type="submit" class="btn btn-primary" @click="editSubject(form.s_id)">
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
