<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { defineProps, defineEmits } from "vue";
const router = useRouter();
let subject = ref({});
const edit = ref(false);
const userId = document.getElementById("app").getAttribute("data-user-id");

let formAdd = ref({
    title: "",
    value: "",
});
let formEdit = ref({
    id: "",
    title: "",
    value: "",
});

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
        console.log("subject", subject.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
// const exportFile = () => {
//     window.open(`/../../users/pdf/${props.id}`, '_blank');
// };

const exportFile = async () => {
    try {
        window.open(`/api/user_get_doc_show/${props.id}`, "_blank");
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const sendFile = () => {
    Swal.fire({
        title: "ยืนยันการจัดทำ มคอ",
        text: "ยืนยันการจัดทำ มคอ",
        icon: "success",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            window.location.href = `/../../users/pdf/export/${props.id}/${userId}`;
        }
    });
};
// const getMeasure_list = async () => {
//     try {
//         let response = await axios.get(`/api/user_get_measure/${props.id}`);
//         measure.value = response.data.measure;
//     } catch (error) {
//         console.error('Error fetching measure:', error);
//     }
// };

// const addMeasure_list = () => {
//     const formData = new FormData();
//     formData.append("title", formAdd.value.title);
//     formData.append("value", formAdd.value.value);
//     axios
//         .post(`/api/user_add_measure/${props.id}`, formData)
//         .then((response) => {
//             formAdd.value.title = ''
//             formAdd.value.value = ''
//             getMeasure_list();
//         })
//         .catch((error) => { });

//     toast.fire({
//         icon: "success",
//         title: "Week hour add successfully",
//     });
// };
// const updateMeasure_list = () => {
//     const formData = new FormData();
//     formData.append("id", formEdit.value.id);
//     formData.append("title", formEdit.value.title);
//     formData.append("value", formEdit.value.value);
//     axios
//         .post(`/api/user_update_measure`, formData)
//         .then((response) => {
//             formEdit.value.id = '',
//                 formEdit.value.title = '',
//                 formEdit.value.value = ''
//             getMeasure_list();
//             $('#edit').modal('hide');
//         })
//         .catch((error) => { });

//     toast.fire({
//         icon: "success",
//         title: "Update Planing update successfully",
//     });
// };
const deleteMeasure_list = (id) => {
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
// const openEditModal = (item) => {
//     console.log(item);
//     edit.value = true;
//     $('#edit').modal('show');
//     formEdit.value = {
//         id: item.ml_id,
//         title: item.ml_title,
//         value: item.ml_value,
//     }
// }
onMounted(async () => {
    await getSubject();
});
</script>

<template>
    <div class="col-lg-9">
        <div class="card" id="basic-info">
            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">ยืนยันรายการการจัดทำ มคอ .</h5>
                    <label class="mb-0 ms-0 text-muted"
                        >ตรวจสอบ มคอ. ที่จัดทำ
                    </label>
                </div>
            </div>
            <div class="card-body pb-3">
                <div class="row">
                    <div class="col-lg-3">
                        <div
                            class="card card-select-doc mt-3"
                            @click="exportFile()"
                            v-if="subject.doc_type == 1"
                        >
                            <div class="card-body">
                                <div
                                    class="icon icon-shape bg-gradient-info shadow text-center"
                                >
                                    <i
                                        class="ni ni-curved-next opacity-10"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                                <h5 class="mt-3 mb-0">
                                    มคอ.3
                                    <span class="text-secondary text-sm"
                                        >m</span
                                    >
                                </h5>
                                <p class="mb-0">มคอ.3 ที่จัดทำ</p>
                            </div>
                        </div>
                        <div
                            class="card card-select-doc"
                            @click="exportFile()"
                            v-if="subject.doc_type == 2"
                        >
                            <div class="card-body">
                                <div
                                    class="icon icon-shape bg-gradient-danger shadow text-center"
                                >
                                    <i
                                        class="ni ni-curved-next opacity-10"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                                <h5 class="mt-3 mb-0">
                                    มคอ.4
                                    <span class="text-secondary text-sm"
                                        >m</span
                                    >
                                </h5>
                                <p class="mb-0">จัดทำ มคอ4</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="d-flex">
                        <div class="me-2">
                            <button class="btn btn-dark" @click="sendFile()">
                                ยืนยันรายการ
                            </button>
                        </div>
                        <div class=" ">
                            <button class="btn btn-outline-secondary">
                                กลับหน้าหลัก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
