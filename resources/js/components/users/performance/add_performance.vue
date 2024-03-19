<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";

const router = useRouter();

let programs = ref([]);
let terms = ref({});
let currentTerm = ref("");
let subjects = ref("");
let selectedTerm = ref("");
const userId = document.getElementById("app").getAttribute("data-user-id");

let form = ref({
    title: "",
    date: "",
    year: "",
    detail: "",
});
const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        currentTerm.value = terms.value[0].t_id;
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};

const getSubject = async () => {
    try {
        let response = await axios.get(
            `/api/get_all_subject/${userId}/${currentTerm.value}`
        );
        subjects.value = response.data.subjects;
        console.log("subjects", subjects.value);
    } catch (error) {
        console.error("Error fetching subjects:", error);
    }
};

const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await getSubject();
};
const PerformanceHome = (id) => {
    router.push("/users/performance/");
};

const AddFile = () => {
    const files = document.getElementById("fileInput").files;
    const formData = new FormData();
    formData.append("title", form.value.title);
    formData.append("date", form.value.date);
    formData.append("year", form.value.year);
    formData.append("detail", form.value.detail);
    for (let i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
    }

    axios
        .post(`/api/user_performance_Addfile/${userId}`, formData)
        .then((response) => {
            form.value.title = "";
            form.value.date = "";
            form.value.year = "";
            form.value.detail = "";
            toast.fire({
                icon: "success",
                title: "Update Planing update successfully",
            });
        })
        .catch((error) => {
            console.error("Error uploading files:", error);
            toast.fire({
                icon: "error",
                title: "Failed to update planing",
            });
        });
};

onMounted(async () => {
    await get_Terms();
    await getSubject();
});
</script>

<template>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-2">
                    <div class="text-center mt-3">
                        <div>
                            <h4 class="mb-0">เพิ่มผลงานทางวิชาการ</h4>
                            <small class="fw-normal text-muted"
                                >เพิ่มผลงานทางวิชาการของอาจารย์</small
                            >
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <label class="mb-0 mt-1" for="">อัพโหลดไฟล์</label>
                            <input
                                type="file"
                                multiple="multiple"
                                class="form-control"
                                id="fileInput"
                            />
                            <label class="mb-0 mt-1" for="">ชื่อผลงาน</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.title"
                            />
                            <label class="mb-0 mt-1" for=""
                                >วันที่เผยแพร่</label
                            >
                            <input
                                type="date"
                                class="form-control"
                                v-model="form.date"
                            />
                            <label class="mb-0 mt-1" for="">ปีที่เผยแพร่</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.year"
                            />
                            <label class="mb-0 mt-1" for="">รายละเอียด</label>
                            <textarea
                                name=""
                                id=""
                                rows="6"
                                class="form-control"
                                v-model="form.detail"
                            ></textarea>
                            <div class="d-flex justify-content-end">
                                <button
                                    class="btn btn-outline-dark me-2 mt-3 float-end"
                                    @click="PerformanceHome()"
                                >
                                    กลับหน้าหลัก
                                </button>
                                <button
                                    class="btn btn-dark mt-3 float-end"
                                    @click="AddFile()"
                                >
                                    บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.text-truncate {
    max-width: 80%;
}

.select-year {
    width: 240px;
    font-size: 16px;
}

.th-1 {
    width: 45%;
}
</style>
