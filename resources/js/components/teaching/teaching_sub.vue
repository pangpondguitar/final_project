<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();

let program = ref({
    name: "",
    detail: "",
});
let terms = ref({});
let term2 = ref({});
let subject = ref({});
let teachers = ref({});
let menu = ref({});
let currentTerm = ref("");
let term_sub = ref({});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_Program = async () => {
    try {
        let response = await axios.get(`/api/get_program/${props.id}`);
        program.value = response.data.program;
        console.log("program", program.value);
    } catch (error) {
        console.error("Error fetching program:", error);
    }
};
const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        console.log("terms", terms.value);
        currentTerm.value = terms.value[0].t_id;
        term2.value = terms.value[0].t_name + "/" + terms.value[0].t_year;
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};

const get_Subject = async () => {
    try {
        let response = await axios.get(
            `/api/get_subject/${props.id}/${currentTerm.value}`
        );
        subject.value = response.data.subject;
        console.log("subject", subject.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const get_all_Teacher = async () => {
    try {
        let response = await axios.get(`/api/get_all_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        console.log("teachers", teachers.value);
    } catch (error) {
        console.error("Error fetching teachers:", error);
    }
};
const get_Term_sub = async () => {
    try {
        let response = await axios.get(
            `/api/get_term_sub/${currentTerm.value}`
        );
        term_sub.value = response.data.term_sub;
        console.log("term_sub", term_sub.value);
    } catch (error) {
        console.error("Error fetching term_sub:", error);
    }
};
const delete_Sub = (id, s_name) => {
    Swal.fire({
        title: "ยืนยันลบรายวิชานี้",
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
                .get("/api/delete_sub/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    get_Term_sub();
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
const term = (t_id, num, year) => {
    // Update the value of currentTerm with the provided t_id
    currentTerm.value = t_id;
    get_Subject(currentTerm.value);
    get_Term_sub();
    term2.value = num + "/" + year;
    // Log the currentTerm to the console
    console.log(currentTerm.value);
};
const menus = (menu_type) => {
    menu.value = menu_type;
};
const saveSub = (s_id) => {
    console.error(s_id);
    const formData = new FormData();
    formData.append("t_id", currentTerm.value);
    formData.append("s_id", s_id);
    get_Term_sub();
    axios
        .post("/api/add_sub", formData)
        .then((response) => {})
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};
const add_Thecher = (ts_id, id) => {
    const formData = new FormData();
    formData.append("ts_id", ts_id);
    formData.append("id", id);
    axios
        .post("/api/add_teacher", formData)
        .then((response) => {})
        .catch((error) => {});

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};
onMounted(async () => {
    await get_Program();
    await get_Terms();
    await get_Subject();
    await get_all_Teacher();
    await get_Term_sub();
});
</script>

<template>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card mb-3">
                <div class="card-body p-3">
                    <h5 class="mb-0">{{ program.p_name }}</h5>
                    <p class="text-sm">{{ program.p_detail }}</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <button
                                class="btn btn-info me-2 fs-6 fw-normal"
                                v-for="item in terms"
                                :key="item.id"
                                @click="
                                    term(item.t_id, item.t_name, item.t_year)
                                "
                            >
                                {{ item.t_name }}/{{ item.t_year }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0" v-if="menu === 'Add'">
                                เพิ่มรายวิชาปีการศึกษา {{ term2 }}
                            </h5>
                            <h5 class="mb-0" v-else>
                                รายวิชาทั้งหมดในปีการศึกษา {{ term2 }}
                            </h5>
                            <p class="text-sm">
                                เลือกรายวิชาต่างๆและเลือกอาจารย์
                            </p>
                        </div>
                        <div>
                            <button
                                class="btn btn-light s-none me-2"
                                @click="menus('All')"
                            >
                                รายวิชาทั้งหมด
                            </button>
                            <button class="btn btn-dark" @click="menus('Add')">
                                เพิ่มรายวิชา
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="menu === 'Add'">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td style="width: 10%">
                                    <label class="ms-3">#</label>
                                </td>
                                <td class="" style="width: 13%">
                                    <label>รหัสวิชา</label>
                                </td>
                                <td><label for="">รหัสวิชา</label></td>
                                <td class="text-center">control</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in subject" :key="item.id">
                                <td class="align-middle">
                                    <div class="form-check ms-3">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="flexCheckDefault"
                                        />
                                    </div>
                                </td>
                                <td class="fw-bold align-middle">
                                    <span class="mb-0 fw-normal fs-6">
                                        {{ item.s_num }}</span
                                    >
                                </td>
                                <td class="align-middle">
                                    <span class="fs-6 mb-0 fw-normal">{{
                                        item.s_name
                                    }}</span>
                                </td>
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-secondary btn-icon-only rounded-circle mb-0 me-2"
                                        @click="saveSub(item.s_id)"
                                    >
                                        <span class="btn-inner--icon"
                                            ><i class="bi bi-plus-circle"></i
                                        ></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td style="width: 10%">
                                    <label class="ms-3">#</label>
                                </td>
                                <td class="" style="width: 13%">
                                    <label>รหัสวิชา</label>
                                </td>
                                <td><label for="">ชื่อรายวิชา</label></td>
                                <td class="text-center">control</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in term_sub" :key="item.id">
                                <td class="align-middle">
                                    <div class="form-check ms-3">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value=""
                                            id="flexCheckDefault"
                                        />
                                    </div>
                                </td>
                                <td class="fw-bold align-middle">
                                    <span class="mb-0 fw-normal fs-6">{{
                                        item.subjects.s_num
                                    }}</span>
                                </td>
                                <td class="align-middle">
                                    <span class="fs-6 mb-0 fw-normal">{{
                                        item.subjects.s_name
                                    }}</span>
                                </td>
                                <td class="text-center">
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary btn-icon-only rounded-circle mb-0 me-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"
                                    >
                                        <span class="btn-inner--icon"
                                            ><i class="bi bi-people-fill"></i
                                        ></span>
                                    </button>
                                    <button
                                        @click="
                                            delete_Sub(
                                                item.ts_id,
                                                item.subjects.s_name
                                            )
                                        "
                                        type="button"
                                        class="btn btn-reddit btn-icon-only rounded-circle mb-0"
                                    >
                                        <span class="btn-inner--icon"
                                            ><i class="bi bi-trash3"></i
                                        ></span>
                                    </button>
                                </td>
                                <div
                                    class="modal fade"
                                    id="exampleModal"
                                    tabindex="-1"
                                    aria-labelledby="exampleModalLabel"
                                    aria-hidden="true"
                                >
                                    <form method="POST" action="">
                                        @csrf
                                        <div
                                            class="modal-dialog modal-dialog-centered modal-md"
                                        >
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2
                                                        class="modal-title fs-5"
                                                        id="exampleModalLabel"
                                                    >
                                                        เพิ่มอาจารย์ผู้สอน
                                                    </h2>
                                                    <button
                                                        type="button"
                                                        class="btn-close text-dark"
                                                        data-bs-dismiss="modal"
                                                        aria-label="Close"
                                                    >
                                                        <span aria-hidden="true"
                                                            >&times;</span
                                                        >
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul
                                                        class="list-group"
                                                        v-for="items in teachers"
                                                        :key="items.id"
                                                    >
                                                        <li
                                                            class="list-group list-group-flush mb-2"
                                                        >
                                                            <div
                                                                class="d-flex justify-content-between align-items-center"
                                                            >
                                                                <div>
                                                                    <label
                                                                        class="mb-0 fw-normal fs-6"
                                                                    >
                                                                        <small
                                                                            class="text-muted"
                                                                            >ผู้สอน</small
                                                                        ><br />
                                                                        {{
                                                                            items
                                                                                .user_detail
                                                                                .user_d_name
                                                                        }}</label
                                                                    >
                                                                </div>
                                                                <div>
                                                                    <button
                                                                        type="button"
                                                                        class="btn btn-success btn-icon-only rounded-circle mb-0 me-2"
                                                                        @click="
                                                                            add_Thecher(
                                                                                item.ts_id,
                                                                                items.id
                                                                            )
                                                                        "
                                                                    >
                                                                        <span
                                                                            class="btn-inner--icon"
                                                                            ><i
                                                                                class="bi bi-plus-circle"
                                                                            ></i
                                                                        ></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<style></style>
