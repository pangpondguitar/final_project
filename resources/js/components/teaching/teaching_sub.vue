<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();

let program = ref({
    name: "",
    detail: "",
});
const showTeacher = ref(true);
let terms = ref({});
let term2 = ref({});
let subject = ref({});
let teachers = ref({});
let teachers_menu = ref({});
let teaching = ref({});
let menu = ref({});
let currentTerm = ref("");
let term_sub = ref({});
let ts_id = ref({});
let input = ref("");
const pagination = ref({});
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
    } catch (error) {
        console.error("Error fetching program:", error);
    }
};
const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
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
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
const get_all_Teacher = async () => {
    try {
        let response = await axios.get(`/api/get_all_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
    } catch (error) {
        console.error("Error fetching teachers:", error);
    }
};
const get_all_Teaching = async () => {
    try {
        let response = await axios.get(`/api/get_all_teaching/${ts_id.value}`);
        teaching.value = response.data.teaching;
    } catch (error) {
        console.error("Error fetching teaching:", error);
    }
};
const get_Term_sub = async (page = 1) => {
    try {
        let response = await axios.get(
            `/api/get_term_sub/${currentTerm.value}/?page=${page}`
        );
        term_sub.value = response.data.term_sub;
        console.log("Term sub:", term_sub.value.data);
        console.log("Filtered list:", filteredList());
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
const delete_Teacher = (id, Tname) => {
    Swal.fire({
        title: "ยืนยันลบอาจารย์ผู้สอน",
        text: Tname,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/delete_Teacher/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    get_all_Teaching();
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
    currentTerm.value = t_id;
    get_Subject(currentTerm.value);
    get_Term_sub();
    term2.value = num + "/" + year;
    console.log(currentTerm.value);
};
const menus = (menu_type) => {
    menu.value = menu_type;
};
const menus_check = (menu_type) => {
    menu.value = menu_type;
    showTeacher.value = true;
};
const teaching_check = (id) => {
    teachers_menu.value = id;
    ts_id.value = id;
    showTeacher.value = false;
    get_all_Teaching();
    console.log(showTeacher.value);
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
const add_Teacher = (ts_id, id) => {
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

console.log(showTeacher);
function filteredList() {
    if (Array.isArray(term_sub.value.data)) {
        console.error("term_sub.value is not an array");
        return term_sub.value.data.filter(
            (item) =>
                item.subjects &&
                item.subjects.s_name &&
                item.subjects.s_num &&
                (item.subjects.s_name
                    .toLowerCase()
                    .includes(input.value.toLowerCase()) ||
                    item.subjects.s_num
                        .toLowerCase()
                        .includes(input.value.toLowerCase()))
        );
    } else {
        // console.error("term_sub.value is not an array");
        return [];
    }
}
// console.log("Filtered list:", filteredList());

onMounted(async () => {
    await get_Program();
    await get_Terms();
    await get_Subject();
    await get_all_Teacher();
    await get_Term_sub();
    await get_all_Teaching();
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
                            <button
                                class="btn btn-dark"
                                @click="menus_check('Add')"
                            >
                                เพิ่มรายวิชา
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div class="row">
                        <div :class="showTeacher ? 'col-lg-12' : 'col-lg-6'">
                            <div v-if="menu === 'Add'">
                                <div class="card">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <td style="width: 10%">
                                                    <label class="ms-3"
                                                        >#</label
                                                    >
                                                </td>
                                                <td class="" style="width: 13%">
                                                    <label>รหัสวิชา</label>
                                                </td>
                                                <td>
                                                    <label for=""
                                                        >รหัสวิชา</label
                                                    >
                                                </td>
                                                <td class="text-center">
                                                    control
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr
                                                v-for="item in subject"
                                                :key="item.id"
                                            >
                                                <td class="align-middle">
                                                    <div
                                                        class="form-check ms-3"
                                                    >
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            value=""
                                                            id="flexCheckDefault"
                                                        />
                                                    </div>
                                                </td>
                                                <td
                                                    class="fw-bold align-middle"
                                                >
                                                    <span
                                                        class="mb-0 fw-normal fs-6"
                                                    >
                                                        {{ item.s_num }}</span
                                                    >
                                                </td>
                                                <td class="align-middle">
                                                    <span
                                                        class="fs-6 mb-0 fw-normal"
                                                        >{{ item.s_name }}</span
                                                    >
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary btn-icon-only rounded-circle mb-0 me-2"
                                                        @click="
                                                            saveSub(item.s_id)
                                                        "
                                                    >
                                                        <span
                                                            class="btn-inner--icon"
                                                            ><i
                                                                class="bi bi-plus-circle"
                                                            ></i
                                                        ></span>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-else>
                                <div>
                                    <input
                                        type="text"
                                        v-model="input"
                                        class="form-control input-search"
                                        placeholder="ค้นหารายวิชา..."
                                    />
                                    <div
                                        class="item fruit"
                                        v-for="item in filteredList()"
                                        :key="item"
                                    ></div>
                                    <div
                                        class="item error"
                                        v-if="input && !filteredList().length"
                                    >
                                        <p>No results found!</p>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="col-lg-3"></div>
                                </div>
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td style="width: 10%">
                                                        <label class="ms-3"
                                                            >#</label
                                                        >
                                                    </td>
                                                    <td
                                                        class=""
                                                        style="width: 13%"
                                                    >
                                                        <label>รหัสวิชา</label>
                                                    </td>
                                                    <td>
                                                        <label for=""
                                                            >ชื่อรายวิชา</label
                                                        >
                                                    </td>
                                                    <td class="text-center">
                                                        <label>control</label>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="item in filteredList()"
                                                    :key="item.id"
                                                >
                                                    <td class="align-middle">
                                                        <div
                                                            class="form-check ms-3"
                                                        >
                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                value=""
                                                                id="flexCheckDefault"
                                                            />
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="fw-bold align-middle"
                                                    >
                                                        <span
                                                            class="mb-0 fw-normal fs-6"
                                                            >{{
                                                                item.subjects
                                                                    .s_num
                                                            }}</span
                                                        >
                                                    </td>
                                                    <td class="align-middle">
                                                        <span
                                                            class="fs-6 mb-0 fw-normal"
                                                            >{{
                                                                item.subjects
                                                                    .s_name
                                                            }}</span
                                                        >
                                                    </td>
                                                    <td class="text-center">
                                                        <button
                                                            type="button"
                                                            class="btn btn-outline-secondary btn-icon-only rounded-circle mb-0 me-2"
                                                            :class="{
                                                                'active text-white':
                                                                    teachers_menu ===
                                                                    item.ts_id,
                                                            }"
                                                            @click="
                                                                teaching_check(
                                                                    item.ts_id
                                                                )
                                                            "
                                                        >
                                                            <span
                                                                class="btn-inner--icon"
                                                                ><i
                                                                    class="bi bi-people-fill"
                                                                ></i
                                                            ></span>
                                                        </button>

                                                        <button
                                                            @click="
                                                                delete_Sub(
                                                                    item.ts_id,
                                                                    item
                                                                        .subjects
                                                                        .s_name
                                                                )
                                                            "
                                                            type="button"
                                                            class="btn btn-reddit btn-icon-only rounded-circle mb-0"
                                                        >
                                                            <span
                                                                class="btn-inner--icon"
                                                                ><i
                                                                    class="bi bi-trash3"
                                                                ></i
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
                                                        <form
                                                            method="POST"
                                                            action=""
                                                        >
                                                            @csrf
                                                            <div
                                                                class="modal-dialog modal-dialog-centered modal-md"
                                                            >
                                                                <div
                                                                    class="modal-content"
                                                                >
                                                                    <div
                                                                        class="modal-header"
                                                                    >
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
                                                                            <span
                                                                                aria-hidden="true"
                                                                                >&times;</span
                                                                            >
                                                                        </button>
                                                                    </div>
                                                                    <div
                                                                        class="modal-body"
                                                                    >
                                                                        <ul
                                                                            class="list-group"
                                                                            v-for="items in teachers"
                                                                            :key="
                                                                                items.id
                                                                            "
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
                                                                                                add_Teacher(
                                                                                                    ts_id,
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
                                        <div class="container">
                                            <Bootstrap5Pagination
                                                :data="term_sub"
                                                @pagination-change-page="
                                                    get_Term_sub
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" v-if="!showTeacher">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div
                                        class="d-flex justify-content-between align-items-center"
                                    >
                                        <div>
                                            <h5 class="mb-0">
                                                เพิ่มอาจารย์ผู้สอนในรายวิชา
                                            </h5>
                                            <p class="text-sm mb-0">
                                                เลือกรายวิชาและเลือกอาจารย์ผู้สอน
                                            </p>
                                        </div>

                                        <div>
                                            <button
                                                type="button"
                                                class="btn btn-success btn-icon-only rounded-circle mb-0 me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#exampleModal"
                                            >
                                                <span class="btn-inner--icon"
                                                    ><i
                                                        class="bi bi-plus-circle"
                                                    ></i
                                                ></span>
                                            </button>
                                        </div>
                                    </div>
                                    <ul
                                        class="list-group list-group-flush mt-4"
                                        v-for="item in teaching"
                                        :key="item.ts_id"
                                    >
                                        <li
                                            class="list-group-item py-2"
                                            v-for="subTeach in item.terms_sub_teach"
                                            :key="subTeach.tst_id"
                                        >
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <div>
                                                    <strong
                                                        >อาจารย์ผู้สอน:</strong
                                                    >
                                                    {{
                                                        subTeach.users
                                                            .user_detail
                                                            .user_d_name
                                                    }}
                                                </div>
                                                <div>
                                                    <i
                                                        class="bi bi-trash3"
                                                        @click="
                                                            delete_Teacher(
                                                                subTeach.tst_id,
                                                                subTeach.users
                                                                    .user_detail
                                                                    .user_d_name
                                                            )
                                                        "
                                                    ></i>
                                                </div>
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
</template>
<style scoped>
/* Add CSS transitions for a smooth effect */
.col-lg-6,
.col-lg-12 {
    transition: all 0.4s ease; /* You can adjust the duration and easing function as needed */
}
.input-search {
    width: 280px !important;
}
.card-menu {
    background-color: #f4f4f4;
}
</style>
