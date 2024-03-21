<script setup>
import { onMounted, ref, watch, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();

let programs = ref([]);
let terms = ref({});
let currentTerm = ref("");
let subjects = ref("");
let performance = ref({});
let performances = ref({});
let performance_file = ref({});
let selectedTerm = ref("");
let isChecked = ref(false);
const count = ref(0);

const isDisabled = computed(() => {
    return !isChecked.value;
});

// สร้าง watcher สำหรับตรวจสอบการเปลี่ยนแปลงในค่าของ isChecked
watch(isChecked, (newValue) => {
    console.log(`ค่า isChecked เปลี่ยนเป็น ${newValue}`);
});

let form = ref({
    pf_name: "",
    pf_date: "",
    pf_year: "",
    pf_detail: "",
});
const userId = document.getElementById("app").getAttribute("data-user-id");
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

const getPerformance_fileById = async () => {
    try {
        let response = await axios.get(
            `/api/user_get_performance_file_edit_byid/${props.id}`
        );
        form.value = response.data.performance;
        performances.value = response.data.performance;
        performance_file.value = response.data.performance.performance_file;
        console.log("performance", performance_file.value);
    } catch (error) {
        console.error("Error fetching performance:", error);
    }
};

const AddPerformance = (id) => {
    router.push("/users/performance/addperformance");
};
const PerformanceHome = (id) => {
    router.push("/users/performance");
};

const FilePerformance = (id) => {
    try {
        window.open(`/api/user_open_performance_file/${id}`, "_blank");
    } catch (error) {
        console.error("Error opening docfile:", error);
    }
};

const EditPerformance = () => {
    const formData = new FormData();
    formData.append("title", form.value.pf_name);
    formData.append("date", form.value.pf_date);
    formData.append("year", form.value.pf_year);
    formData.append("detail", form.value.pf_detail);

    axios
        .post(`/api/user_performance_Edit/${props.id}`, formData)
        .then((response) => {
            form.value.title = "";
            form.value.date = "";
            form.value.year = "";
            form.value.detail = "";
            toast.fire({
                icon: "success",
                title: "Update Performance update successfully",
            });
            getPerformance_fileById();
        })
        .catch((error) => {
            console.error("Error uploading files:", error);
            toast.fire({
                icon: "error",
                title: "Failed to update planing",
            });
        });
};
const AddFilePerformance = () => {
    const files = document.getElementById("fileInput").files;
    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
    }

    axios
        .post(`/api/user_performance_add_file_edit/${props.id}`, formData)
        .then((response) => {
            toast.fire({
                icon: "success",
                title: "Update Planing update successfully",
            });
            getPerformance_fileById();
        })
        .catch((error) => {
            console.error("Error uploading files:", error);
            toast.fire({
                icon: "error",
                title: "Failed to update planing",
            });
        });
};
const Delete_PerformanceFile = (id) => {
    Swal.fire({
        title: "ยืนยันลบข้อมูลไฟล์นี้",
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
                .get("/api/user_delete_performance_file/" + id)
                .then(() => {
                    Swal.fire("Delete", "File delete successfully", "success");
                    getPerformance_fileById();
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
const Delete_Performance = () => {
    Swal.fire({
        title: "ยืนยันลบข้อมูลไฟล์นี้",
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
                .get(`/api/user_delete_performance/${props.id}`)
                .then(() => {
                    Swal.fire("Delete", "File delete successfully", "success");
                    PerformanceHome();
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
    await getPerformance_fileById();
});
</script>

<template>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4">แก้ไขข้อมูลผลงานทางวิชาการ</h6>
                    <label class="mb-0 mt-2" for="">ชื่อผลงาน</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.pf_name"
                    />
                    <label class="mb-0 mt-2" for="">วันที่เผยแพร่</label>
                    <input
                        type="date"
                        class="form-control"
                        v-model="form.pf_date"
                    />
                    <label class="mb-0 mt-2" for="">ปีที่เผยแพร่</label>
                    <input
                        type="text"
                        class="form-control"
                        v-model="form.pf_year"
                    />
                    <label class="mb-0 mt-2" for="">รายละเอียด</label>
                    <textarea
                        name=""
                        id=""
                        rows="6"
                        class="form-control"
                        v-model="form.pf_detail"
                    ></textarea>
                    <div class="d-flex justify-content-end">
                        <button
                            class="btn btn-dark mt-3 float-end"
                            @click="EditPerformance()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="mb-4">ไฟล์ผลงานทั้งหมด</h6>
                    <label class="mb-0 mt-1" for="">อัพโหลดไฟล์</label>
                    <input
                        type="file"
                        multiple="multiple"
                        class="form-control"
                        id="fileInput"
                    />
                    <div class="col-lg-12 mt-3">
                        <ul class="list-group list-group-flush mt-3">
                            <li
                                class="list-group-item"
                                v-for="file in performance_file"
                                :key="file.pff_id"
                            >
                                <a
                                    class="d-flex align-items-center justify-content-between"
                                >
                                    <div
                                        class="d-flex"
                                        @click="FilePerformance(file.pff_id)"
                                    >
                                        <div class="me-3">
                                            <img
                                                src="/public/assets/img/pdf (9).png"
                                                alt="slack_logo"
                                                class="img-perfor-edit"
                                            />
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <p
                                                class="mb-0 fz-fname-edit text-muted"
                                            >
                                                {{ file.pff_name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <i
                                            class="bi bi-trash3 text-danger"
                                            @click="
                                                Delete_PerformanceFile(
                                                    file.pff_id
                                                )
                                            "
                                        ></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <button
                        class="btn btn-dark float-end"
                        @click="AddFilePerformance()"
                    >
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card" id="delete">
                <div class="card-header">
                    <h5>Delete Performance</h5>
                    <p class="text-sm mb-0">
                        Once you delete your account, there is no going back.
                        Please be certain.
                    </p>
                </div>
                <div class="card-body d-sm-flex pt-0">
                    <div class="d-flex align-items-center mb-sm-0 mb-4">
                        <div>
                            <div class="form-check form-switch mb-0">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="flexSwitchCheckDefault0"
                                    v-model="isChecked"
                                />
                            </div>
                        </div>
                        <div class="ms-2">
                            <span
                                class="text-dark font-weight-bold d-block text-sm"
                                >Confirm</span
                            >
                            <span class="text-xs d-block"
                                >I want to delete my account.</span
                            >
                        </div>
                    </div>
                    <button
                        class="btn btn-outline-secondary mb-0 ms-auto"
                        type="button"
                        name="button"
                    >
                        Go TO Home
                    </button>
                    <button
                        class="btn bg-gradient-danger mb-0 ms-2"
                        type="button"
                        name="button"
                        :disabled="isDisabled"
                        @click="Delete_Performance()"
                    >
                        Delete Performance
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.img-perfor-edit {
    width: 30px;
}

.fz-fname-edit {
    font-size: 14px;
}
</style>
