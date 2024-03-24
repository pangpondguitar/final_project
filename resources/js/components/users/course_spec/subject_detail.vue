<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();

let subjectTname = ref({});
let teachers = ref({});
let subject = ref({});
let docfile = ref({});
let df_id = ref({});
let doc_status = ref({});

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
const get_Subject_teach = async () => {
    try {
        let response = await axios.get(`/api/get_subject_teach/${props.id}`);
        subjectTname.value = response.data.subject;
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};

const get_teachers = async () => {
    try {
        let response = await axios.get(`/api/get_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const getDoc_file = async () => {
    try {
        let response = await axios.get(`/api/user_get_docfile/${props.id}`);
        docfile.value = response.data.docfile;

        console.log("docfile", docfile.value);
    } catch (error) {
        console.error("Error fetching docfile:", error);
    }
};

const Open_Docfile = () => {
    try {
        const dfIds = docfile.value.map((item) => item.df_id);
        window.open(`/api/user_get_docfile_finish/${dfIds}`, "_blank");
    } catch (error) {
        console.error("Error opening docfile:", error);
    }
};
const FormatDate = (item) => {
    const dateTimeString = item;
    const dateTime = new Date(dateTimeString);

    const thaiDateString = dateTime.toLocaleDateString("th-TH");
    return thaiDateString;
};
const delete_Docfile = () => {
    const dfIds = docfile.value.map((item) => item.df_id);
    Swal.fire({
        title: "ยืนยันลบไฟล์เอกสาร",
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
                .get("/api/user_delete_docfile/" + dfIds)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    getDoc_file();
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
const Subdoc_fisrt = (id) => {
    router.push("/users/course_spec/subdoc/" + id);
};
const get_doc_status = async (id) => {
    try {
        const dfIds = docfile.value.map((item) => item.df_id);
        let response = await axios.get(
            `/api/admin_get_docfile_status/${dfIds}`
        );
        doc_status.value = response.data.doc_status;
        console.log("doc_status", doc_status.value);
    } catch (error) {
        console.error("Error fetching doc_status:", error);
    }
};
onMounted(async () => {
    await get_Subject_teach();
    await get_teachers();
    await getSubject();
    await getDoc_file();
    await get_doc_status();
});
</script>

<template>
    <div class="row">
        <div v-for="subject in subjectTname" :key="subject.ts_id">
            <h4 class="mb-0">{{ subject.subjects.s_name }}</h4>

            <h4 class="fw-normal text-muted h6">
                รายวิชา{{ subject.subjects.s_name }}
            </h4>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-lg-4">
            <!-- <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-2">จัดทำ มคอ.</h4>
                </div>

            </div> -->
            <div class="row">
                <div class="col-lg-6">
                    <div
                        class="card bg-gradient-dark shadow"
                        @click="Subdoc_fisrt(props.id)"
                    >
                        <div class="card-body">
                            <!-- <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                <i class="ni ni-curved-next opacity-10" aria-hidden="true"></i>
                            </div> -->
                            <div class="h2 text-white">3</div>
                            <h5 class="mt-1 mb-0 text-white fw-normal">
                                อาจารย์ผู้สอน<span
                                    class="text-secondary text-sm"
                                ></span>
                            </h5>
                            <p class="mb-0 text-white">ทั้งหมด</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div
                        class="card bg-gradient-warning"
                        @click="Subdoc_fisrt(props.id)"
                    >
                        <div class="card-body">
                            <!-- <div class="icon icon-shape bg-gradient-dark shadow text-center">
                                <i class="ni ni-curved-next opacity-10" aria-hidden="true"></i>
                            </div> -->
                            <div class="h2 text-white">2</div>
                            <h5 class="mt-1 mb-0 text-white fw-normal">
                                อาจารย์ผู้สอน<span
                                    class="text-secondary text-sm"
                                ></span>
                            </h5>
                            <p class="mb-0 text-white">ทั้งหมด</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-0">
                                                สถานะการจัดทำ มคอ.
                                            </h5>
                                            <span class="text-xs fw-normal"
                                                >รายละเอียดสถานะการส่ง มคอ</span
                                            >
                                        </div>
                                        <div>
                                            <span class="badge badge-success"
                                                >ตรวจสอบแล้ว</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4" v-show="docfile.length == 1">
                                <div class="d-flex">
                                    <img
                                        class="pdf-icon"
                                        src=" /public/assets/img/pdf (9).png"
                                        @click="Open_Docfile()"
                                    />
                                    <i
                                        class="bi bi-trash3 text-danger ms-3"
                                        @click="delete_Docfile()"
                                    ></i>
                                </div>
                            </div>
                            <div class="row" v-if="docfile.length == 0">
                                <div class="col-lg-12">
                                    <div
                                        class="card bg-light text-center card-empty-doc mt-2"
                                    >
                                        <div class="card-body p-5">
                                            <img
                                                class="pdf-icon"
                                                src=" /public/assets/img/pdf (9).png"
                                            />
                                            <p>ยังไม่มีไฟล์เอกสารในขณะนี้</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="timeline timeline-one-side mt-4"
                                v-if="doc_status.length > 0"
                            >
                                <div
                                    class="timeline-block mb-3"
                                    v-for="item in doc_status"
                                    :key="item.id"
                                >
                                    <span class="timeline-step">
                                        <i
                                            class="ni ni-bell-55 text-warning text-gradient"
                                            v-if="item.dfs_status == 0"
                                        ></i>
                                        <i
                                            class="ni ni-bell-55 text-success text-gradient"
                                            v-if="item.dfs_status == 1"
                                        ></i>
                                        <i
                                            class="ni ni-bell-55 text-success text-secondary"
                                            v-if="item.dfs_status == 2"
                                        ></i>
                                    </span>
                                    <div
                                        class="timeline-content"
                                        v-if="item.dfs_status == 0"
                                    >
                                        <h6
                                            class="text-dark text-sm font-weight-bold mb-0"
                                        >
                                            สถานะ : รอตรวจสอบ
                                        </h6>
                                        <p
                                            class="text-secondary font-weight-bold text-xs mt-1 mb-0"
                                        >
                                            วันที่ยืนยันรายการ :
                                            {{ FormatDate(item.created_at) }}
                                        </p>
                                    </div>
                                    <div
                                        class="timeline-content"
                                        v-if="item.dfs_status == 1"
                                    >
                                        <h6
                                            class="text-dark text-sm font-weight-bold mb-0"
                                        >
                                            สถานะ : เสร็จสิ้น
                                        </h6>
                                        <p
                                            class="text-secondary font-weight-bold text-xs mt-1 mb-0"
                                        >
                                            วันที่ยืนยันรายการ :
                                            {{ FormatDate(item.created_at) }}
                                        </p>
                                    </div>
                                    <div
                                        class="timeline-content"
                                        v-if="item.dfs_status == 2"
                                    >
                                        <h6
                                            class="text-dark text-sm font-weight-bold mb-0"
                                        >
                                            สถานะ : จัดทำเอกสารใหม่อีกครั้ง
                                        </h6>
                                        <p
                                            class="text-secondary font-weight-bold text-xs mt-1 mb-0"
                                        >
                                            วันที่ยืนยันรายการ :
                                            {{ FormatDate(item.created_at) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="timeline timeline-one-side mt-4"
                                v-if="doc_status.length == 0"
                            >
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step">
                                        <i
                                            class="ni ni-html5 text-danger text-gradient"
                                        ></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6
                                            class="text-dark text-sm font-weight-bold mb-0"
                                        >
                                            สถานะ : ยังไม่จัดทำเอกสาร
                                        </h6>
                                        <p
                                            class="text-secondary font-weight-bold text-xs mt-1 mb-0"
                                        >
                                            ยังไม่จัดทำเอกสาร มคอ.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-0">อาจารย์ผู้สอน</h5>
                            <span class="text-xs fw-normal"
                                >อาจารย์ผู้สอนรายวิชา</span
                            >
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <ul
                        class="list-group"
                        v-for="teacher in teachers"
                        :key="teacher.ts_id"
                    >
                        <li
                            class="list-group-item border-0 d-flex align-items-center px-0 mb-2 border border-bottom"
                            v-for="termTeach in teacher.terms_sub_teach"
                            :key="termTeach.tst_id"
                        >
                            <div class="avatar me-3">
                                <div
                                    class="icon icon-shape icon-shape-bg shadow text-center border-radius-md shadow-none"
                                >
                                    <i
                                        class="ni ni-money-coins text-lg text-info text-gradient opacity-10"
                                        aria-hidden="true"
                                    ></i>
                                </div>
                            </div>
                            <div
                                class="d-flex align-items-start flex-column justify-content-center"
                            >
                                <h6 class="mb-0">
                                    {{
                                        termTeach.users.user_detail.user_d_name
                                    }}
                                </h6>
                                <p class="mb-0 text-xs">
                                    Hi! I need more information..
                                </p>
                            </div>
                            <a
                                class="btn btn-link pe-3 ps-0 mb-0 ms-auto"
                                href="javascript:;"
                                >Reply</a
                            >
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-0">ไฟล์เอกสาร มคอ.</h5>
                                    <span class="fw-normal text-xs"
                                        >จัดทำไฟล์เอกสาร มคอ.</span
                                    >
                                </div>
                                <div>
                                    <span class="badge badge-danger">pdf</span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div
                                    class="card card-select-doc"
                                    @click="Subdoc_fisrt(props.id)"
                                    v-show="
                                        subject.doc_type == 1 &&
                                        docfile.length == 0
                                    "
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
                                        <p class="mb-0">จัดทำ มคอ3</p>
                                    </div>
                                </div>

                                <div
                                    class="card card-do-success"
                                    v-show="
                                        subject.doc_type == 1 &&
                                        docfile.length == 1
                                    "
                                >
                                    <div class="card-body">
                                        <div
                                            class="icon icon-shape bg-gradient-success shadow text-center"
                                        >
                                            <i
                                                class="ni ni-curved-next opacity-10"
                                                aria-hidden="true"
                                            ></i>
                                        </div>
                                        <h5 class="mt-3 mb-0 text-success">
                                            จัดทำ มคอ.3
                                        </h5>
                                        <label class="text-dark ms-0"
                                            >สถานะเสร็จสิ้น</label
                                        >
                                    </div>
                                </div>
                                <div
                                    class="card card-select-doc"
                                    @click="Subdoc_fisrt(props.id)"
                                    v-show="
                                        subject.doc_type == 2 &&
                                        docfile.length == 0
                                    "
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
                                <div
                                    class="card card-do-success"
                                    v-show="
                                        subject.doc_type == 2 &&
                                        docfile.length == 1
                                    "
                                >
                                    <div class="card-body">
                                        <div
                                            class="icon icon-shape bg-gradient-success shadow text-center"
                                        >
                                            <i
                                                class="ni ni-curved-next opacity-10"
                                                aria-hidden="true"
                                            ></i>
                                        </div>
                                        <h5 class="mt-3 mb-0 text-success">
                                            จัดทำ มคอ.4
                                        </h5>
                                        <label class="text-dark ms-0"
                                            >สถานะเสร็จสิ้น</label
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body"></div>
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

.card-2 {
    height: 400px !important;
}

.card-select-doc {
    box-shadow: none;
    background-color: #f1f1f1;
}

.card-do-success {
    /* background-color: #cdf59b; */
    box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px,
        rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
}

.pdf-icon {
    width: 80px;
    transition: 0.3s;
}

.pdf-icon:hover {
    transform: scale(1.1);
    transition: 0.3s;
}

.icon-shape-bg {
    background-color: #f3f3f3;
}
</style>
