<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

let course = ref({});
let course_file = ref({});
let form = ref({
    c_name: "",
    c_name2: "",
});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_course_detail = async () => {
    try {
        let response = await axios.get(
            `/api/admin_get_single_course/${props.id}`
        );
        form.value = response.data.course;
        console.log(response.data.course);
    } catch (error) {
        console.error("Error fetching course:", error);
    }
};
const get_course_file = async () => {
    try {
        let response = await axios.get(`/api/admin_get_course_doc/${props.id}`);
        course_file.value = response.data.course;
        console.log(response.data.course_file);
    } catch (error) {
        console.error("Error fetching course:", error);
    }
};

const delete_course = (id) => {
    Swal.fire({
        title: "ยืนยันการลบข้อมูล",
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
                .get("/api/admin_delete_course/" + id)
                .then(() => {
                    Go_to_course_home();
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

const AddFile = () => {
    const files = document.getElementById("fileInput").files;
    const formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append("files[]", files[i]);
    }
    axios
        .post(`/api/admin_add_course_doc/${props.id}`, formData)
        .then((response) => {
            toast.fire({
                icon: "success",
                title: "Update Planing update successfully",
            });
            get_course_file();
        })
        .catch((error) => {
            console.error("Error uploading files:", error);
            toast.fire({
                icon: "error",
                title: "Failed to update planing",
            });
        });
};

const FilecourseOpen = (id) => {
    try {
        window.open(`/api/user_open_course_doc_file/${id}`, "_blank");
    } catch (error) {
        console.error("Error opening docfile:", error);
    }
};

const Delete_Course_doc = (id) => {
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
                .get("/api/admin_delete_course_doc/" + id)
                .then(() => {
                    Swal.fire("Delete", "File delete successfully", "success");
                    get_course_file();
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

const update_course = () => {
    const formData = new FormData();
    formData.append("c_name", form.value.c_name);
    formData.append("c_name2", form.value.c_name2);
    formData.append("id", props.id);
    axios
        .post(`/api/admin_update_course/${props.id}`, formData)
        .then((response) => {
            (form.value.c_name = ""), (form.value.c_name2 = "");
            get_course_detail();
        })
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};
const Go_to_course_home = () => {
    router.push("/admin/courses");
};
onMounted(async () => {
    await get_course_detail();
    await get_course_file();
});
</script>
<template>
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header pb-0">
                <h5 class="mb-0">รายละเอียดข้อมูลหลักสูตร</h5>
                <p class="text-sm">รายละเอียดข้อมูลหลักสูตร</p>
            </div>
            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">ชื่อหลักสูตร</label>
                        <div class="input-group">
                            <input
                                id="firstName"
                                name="name"
                                class="form-control"
                                type="text"
                                placeholder="ชื่อหลักสูตร"
                                required="required"
                                v-model="form.c_name"
                            />
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">ชื่อหลักสูตรภาษาอังกฤษ</label>
                        <div class="input-group">
                            <input
                                id="lastName"
                                name="name2"
                                class="form-control"
                                type="text"
                                placeholder="ชื่อหลักสูตร(ภาษาอังกฤษ)"
                                required="required"
                                v-model="form.c_name2"
                            />
                        </div>
                    </div>
                </div>
                <div class="row"></div>

                <div class="row">
                    <div class="col-lg-12">
                        <label class="form-label mt-4">รายละเอียด</label>
                        <textarea
                            name="address"
                            class="form-control"
                            id=""
                            cols="30"
                            rows="3"
                        ></textarea>
                    </div>
                </div>

                <div class="row d-flex text-end mt-3">
                    <div class="col-lg-12">
                        <button
                            class="btn bg-gradient-dark mb-0 px-5 fw-normal text-sm"
                            @click="update_course()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header pb-0">
                <h5 class="mb-0">อัพโหลดไฟล์เอกสารเล่มหลักสูตร</h5>
                <p class="text-sm">อัพโหลดไฟล์เอกสาร</p>
            </div>
            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="mb-0 mt-1" for="">อัพโหลดไฟล์</label>
                        <input
                            type="file"
                            multiple="multiple"
                            class="form-control"
                            id="fileInput"
                        />
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-12 mt-3">
                            <ul class="list-group list-group-flush mt-3">
                                <li
                                    class="list-group-item"
                                    v-for="file in course_file"
                                    :key="file.dcf_id"
                                >
                                    <a
                                        class="d-flex align-items-center justify-content-between"
                                    >
                                        <div
                                            class="d-flex"
                                            @click="FilecourseOpen(file.dcf_id)"
                                        >
                                            <div class="me-3">
                                                <img
                                                    src="/public/assets/img/pdf (9).png"
                                                    alt="slack_logo"
                                                    class="img-perfor-edit"
                                                />
                                            </div>
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <p
                                                    class="mb-0 fz-fname-edit text-muted"
                                                >
                                                    {{ file.dcf_name }}
                                                </p>
                                            </div>
                                        </div>
                                        <div>
                                            <i
                                                class="bi bi-trash3 text-danger"
                                                @click="
                                                    Delete_Course_doc(
                                                        file.dcf_id
                                                    )
                                                "
                                            ></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row d-flex text-end mt-3">
                    <div class="col-lg-12">
                        <button
                            class="btn bg-gradient-dark mb-0 px-5 fw-normal text-sm"
                            @click="AddFile()"
                        >
                            บันทึกข้อมูล
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card" id="delete">
            <div class="card-header">
                <h5 class="mb-1">ลบข้อมูลหลักสูตร</h5>
                <p class="text-sm mb-0">
                    กรุณายืนยันการลบข้อมูลหลักสูตร
                    คุณแน่ใจหรือในการลบข้อมูลหลักสูตรออกจากระบบเมื่อลบแล้วไม่สามารถกู้คืนข้อมูลดังกล่าวได้
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
                            />
                        </div>
                    </div>
                    <div class="ms-2">
                        <span class="text-dark font-weight-bold d-block text-sm"
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
                    Deactivate
                </button>
                <button
                    class="btn bg-gradient-danger mb-0 ms-2"
                    @click="delete_course(props.id)"
                >
                    ลบข้อมูลหลักสูตร
                </button>
            </div>
        </div>
    </div>
</template>

<style></style>
