<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { Bootstrap5Pagination } from "laravel-vue-pagination";

import Checkbox from 'primevue/checkbox';
const checked = ref(false);
const router = useRouter();
const filters = ref({
    global: { value: '' }
});
let program = ref({
    name: "",
    detail: "",
});
const showTeacher = ref(true);
let terms = ref({});
let term2 = ref({});
let subject = ref([]);
let teachers = ref([]);
let teachers_menu = ref({});
let teaching = ref([]);
let menu = ref({});
let currentTerm = ref("");
let term_sub = ref([]);
let ts_id = ref({});
let input = ref("");
const isLoadingData = ref(true);
const modalremark = ref(false);
let checkedItems = ref([]);
let checkedItemsteach = ref([]);
const pagination = ref({
    rows: 10,
    totalRecords: 120,
    rowsPerPageOptions: [10, 20, 30],
});
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

let form = ref({
    id: "",
    title: "",
});
const openRemarkModal = (item) => {
    form.value.title = item.ts_id
    modalremark.value = true;
    get_all_Teacher();
    get_all_Teaching(item.ts_id);
    $("#ModalRemark").modal("show");
};

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
        console.log("currentTerm:", currentTerm.value);
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};


const get_Term_sub = async () => {
    try {
        let response = await axios.get(
            `/api/get_term_sub/${currentTerm.value}/${props.id}`
        );
        term_sub.value = response.data.term_sub;

    } catch (error) {
        console.error("Error fetching term_sub:", error);
    }
};

const get_all_Teacher = async () => {
    try {
        let response = await axios.get(`/api/get_all_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        console.log(teachers.value);
        checkedItemsteach.value = [];

        teachers.value.forEach((item) => {
            if (
                Array.isArray(teaching.value) &&
                teaching.value.length > 0
            ) {
                const foundInMark = teaching.value.some(
                    (markItem) => item.id.toString() === markItem.terms_sub_teach.id
                );
                if (foundInMark) {
                    item.checked = true;
                    checkedItemsteach.value.push(item.id);
                    console.log("Pushed item ID:", item.id);
                } else {
                    item.checked = false;
                }
            } else {
                item.checked = false;
                console.log("remark is not an array or it's empty");
            }
        });
        console.log(checkedItemsteach.value);

    } catch (error) {
        console.error("Error fetching teachers:", error);
    }
};
const get_all_Teaching = async (ts_id) => {
    try {
        let response = await axios.get(`/api/get_all_teaching/${ts_id}`);
        teaching.value = response.data.teaching;
        console.log("teahing", teaching.value);
    } catch (error) {
        console.error("Error fetching teaching:", error);
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
    console.log(currentTerm.value);
    get_Subject(currentTerm.value);
    get_Term_sub();
    term2.value = num + "/" + year;

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


const add_Subjects = () => {
    const formData = new FormData();
    checkedItems.value.forEach((item) => {
        formData.append("subjectsId[]", item);
    });
    axios
        .post(`/api/add_subjects/${currentTerm.value}/${props.id}`, formData)
        .then((response) => { })
        .catch((error) => { });
    toast.fire({
        icon: "success",
        title: "List Result add successfully",
    });
};
const add_Teacher = (ts_id, id) => {
    const formData = new FormData();
    formData.append("ts_id", ts_id);
    formData.append("id", id);
    axios
        .post("/api/add_teacher", formData)
        .then((response) => { })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
    get_all_Teaching();
};
const get_Subject = async () => {
    try {
        get_Term_sub();
        let response = await axios.get(
            `/api/get_subject/${props.id}/${currentTerm.value}`
        );
        subject.value = response.data.subject;
        console.log("Term sub:", term_sub.value);
        console.log("Subject:", subject.value);
        checkedItems.value = [];
        subject.value.forEach((item) => {
            if (
                Array.isArray(term_sub.value) &&
                term_sub.value.length > 0
            ) {
                const foundInMark = term_sub.value.some(
                    (markItem) => item.s_id.toString() === markItem.s_id
                );
                if (foundInMark) {
                    item.checked = true;
                    checkedItems.value.push(item.s_id);
                    console.log("Pushed item ID:", item.s_id);
                } else {
                    item.checked = false;
                }
            } else {
                item.checked = false;
                console.log("remark is not an array or it's empty");
            }
        });
        console.log(checkedItems.value);
    } catch (error) {
        console.error("Error fetching subject:", error);
    }
};
function filteredList() {
    if (Array.isArray(term_sub.value.data)) {
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

const filteredListSubject = () => {
    return subject.value.filter((item) =>
        item.s_name
            .toLowerCase()
            .includes(input.value.toLowerCase())
    );
};
const filteredListTermSubject = () => {
    return term_sub.value.filter((item) =>
        item.s_id
            .toLowerCase()
            .includes(input.value.toLowerCase())
    );
};
const updateCheckedItems = () => {
    console.log("Checked Items:", checkedItems.value);
};
const updateCheckedItems2 = () => {
    console.log("Checked Items:", checkedItemsteach.value);
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
    <div class="modal fade" id="ModalRemark" tabindex="-1" aria-labelledby="ModalRemark" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-lg-12 ps-3 mt-2">
                            <h1 class="modal-title fs-5  mb-0 " id="ModalRemark">
                                เพิ่มอาจารย์ผู้สอนในรายวิชา
                            </h1>
                            <p class="py-0">{{ form.title }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-body py-0 px-0">
                    <div class="row py-3">
                        <div class="col-lg-12">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item  " v-for="item in teachers" :key="item.id">
                                    <div class="d-flex ms-2  align-item-center ">
                                        <div class="">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    v-model="checkedItemsteach" @change="updateCheckedItems2"
                                                    :value="item.id" />
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <label for="" class="text-sm  ms-2 mb-0"> {{ item.user_detail.user_d_name }}
                                            </label>
                                            <label for="" class="text-sm fw-normal text-muted ms-2 mb-0">ชื่ออาจารย์
                                            </label>

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light text-sm fw-normal text-dark"
                        data-bs-dismiss="modal">
                        ยกเลิก
                    </button>
                    <button type="button" class="btn bg-gradient-primary fw-normal text-sm"
                        @click="add_result_remark()">
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card mb-0">
                <div class="card-body p-3">
                    <h5 class="mb-0">{{ program.p_name }}</h5>
                    <p class="text-sm">{{ program.p_detail }}</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-info me-2 fs-6 fw-normal" v-for="item in terms" :key="item.id"
                                @click="
                                term(item.t_id, item.t_name, item.t_year)
                                ">
                                {{ item.t_name }}/{{ item.t_year }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <div class="card mb-4 pb-3">
                <div class="card-header pb-3">
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
                            <button class="btn btn-light s-none me-2" @click="menus('All')">
                                รายวิชาทั้งหมด
                            </button>
                            <button class="btn btn-dark" @click="menus_check('Add')">
                                เพิ่มรายวิชา
                            </button>
                        </div>
                    </div>
                </div>
                <div v-if="menu === 'Add'">
                    <div class="card-body py-0 pb-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <input type="text" v-model="input" class="form-control input-search"
                                        placeholder="ค้นหารายวิชา..." />
                                    <div class="item fruit" v-for=" item  in  filteredListSubject() " :key="item"></div>
                                    <div class="item error" v-if="input && !filteredListSubject().length">
                                        <p>No results found!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <DataTable :value="filteredListSubject()" :paginator="true" :rows="pagination.rows"
                        :rowsPerPageOptions="[5, 10, 20, 50]" :showGridlines="true" v-model:filters="filters">
                        <Column header="" :style="{ width: '0.5%' }">

                        </Column>
                        <Column header="#" :style="{ width: '0.5%' }" class="ms-5">
                            <template v-slot:body="{ data }">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" :value="data.s_id"
                                        v-model="checkedItems" @change="updateCheckedItems" />
                                </div>
                            </template>

                        </Column>
                        <Column header="รหัสวิชา" :style="{ width: '1%' }">
                            <template v-slot:body="{ data }">
                                <p class="text-sm text-dark mb-0 fw-bold">
                                    {{ data.s_num }}

                                </p>
                            </template>
                        </Column>
                        <Column header="รายวิชา" :style="{ width: '25%' }">
                            <template v-slot:body="{ data }">
                                <p class="text-sm text-dark mb-0 fw-bold" :style="{ width: '250px' }">
                                    {{ data.s_name }}

                                </p>
                                <p class="text-xs mb-0 text-secondary"> {{ data.s_name2 }}</p>
                            </template>
                        </Column>
                    </DataTable>
                    <div class="card-body py-0">
                        <div class="row">
                            <div class="d-flex justify-content-end">
                                <div class="me-2 mb-0">
                                    <button
                                        class="btn btn-white text-dark border border-light shadow-none text-sm fw-normal mb-0">
                                        กลับสู่หน้าหลัก</button>

                                </div>
                                <div class=" float-end mb-0">
                                    <button class="btn bg-gradient-dark text-sm fw-normal col-lg-12 mb-0"
                                        @click="add_Subjects()">บันทึกข้อมูล
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <div class="card-body py-0">

                        <DataTable :value="filteredListTermSubject()" :paginator="true" :rows="pagination.rows"
                            :rowsPerPageOptions="[5, 10, 20, 50]" :showGridlines="true" v-model:filters="filters">


                            <Column header="รหัสวิชา" :style="{ width: '89%' }" class="hover:bg-gray-100">
                                <template v-slot:body="{ data }">
                                    <p class="text-sm text-dark mb-0 fw-bold " :style="{ width: '250px' }">
                                        รหัสวิชา {{ data.subjects.s_num }}

                                    </p>
                                    <p class="text-sm mb-0 text-secondary"> {{ data.subjects.s_name }}</p>
                                </template>
                            </Column>
                            <Column header="อาจารย์ผู้สอน" :style="{ textAlign: 'center' }" class="text-center">
                                <template v-slot:body="{ data }">
                                    <div class="d-flex ms-4">

                                        <button type="button" class="btn  bg-gradient-primary  mb-0 me-2 "
                                            @click="openRemarkModal(data)">
                                            <span class="btn-inner--icon"><i class="bi bi-people-fill"></i></span>
                                        </button>
                                    </div>


                                </template>
                            </Column>
                        </DataTable>
                    </div>
                </div>
                <!-- <div class="card-body pt-2">
                    <div class="row">
                        <div :class="showTeacher ? 'col-lg-12' : 'col-lg-6'">

                            <div>
                                <div>
                                    <input type="text" v-model="input" class="form-control input-search"
                                        placeholder="ค้นหารายวิชา..." />
                                    <div class="item fruit" v-for=" item  in  filteredList() " :key="item"></div>
                                    <div class="item error" v-if="input && !filteredList().length">
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
                                                        <label class="ms-3">#</label>
                                                    </td>
                                                    <td class="" style="width: 13%">
                                                        <label>รหัสวิชา</label>
                                                    </td>
                                                    <td>
                                                        <label for="">ชื่อรายวิชา</label>
                                                    </td>
                                                    <td class="text-center">
                                                        <label>control</label>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for=" item  in  term_sub " :key="item.id">
                                                    <td class="align-middle">
                                                        <div class="form-check ms-3">
                                                            <input class="form-check-input" type="checkbox" value=""
                                                                id="flexCheckDefault" />
                                                        </div>
                                                    </td>
                                                    <td class="fw-bold align-middle">
                                                        <span class="mb-0 fw-normal fs-6">{{ item.subjects.s_num
                                                            }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="fs-6 mb-0 fw-normal">{{ item.subjects.s_name
                                                            }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-icon-only rounded-circle mb-0 me-2"
                                                            :class="{
                        'active text-white': teachers_menu ===
                            item.ts_id,
                    }
                        " @click="
                        teaching_check(
                            item.ts_id
                        )
                        ">
                                                            <span class="btn-inner--icon"><i
                                                                    class="bi bi-people-fill"></i></span>
                                                        </button>

                                                        <button @click="
                        delete_Sub(
                            item.ts_id,
                            item
                                .subjects
                                .s_name
                        )
                        " type="button" class="btn btn-reddit btn-icon-only rounded-circle mb-0">
                                                            <span class="btn-inner--icon"><i
                                                                    class="bi bi-trash3"></i></span>
                                                        </button>
                                                    </td>
                                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <form method="POST" action="">
                                                            @csrf
                                                            <div class="modal-dialog modal-dialog-centered modal-md">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h2 class="modal-title fs-5"
                                                                            id="exampleModalLabel">
                                                                            เพิ่มอาจารย์ผู้สอน
                                                                        </h2>
                                                                        <button type="button"
                                                                            class="btn-close text-dark"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <ul class="list-group"
                                                                            v-for=" items  in  teachers " :key="items.id
                        ">
                                                                            <li
                                                                                class="list-group list-group-flush mb-2">
                                                                                <div
                                                                                    class="d-flex justify-content-between align-items-center">
                                                                                    <div>
                                                                                        <label
                                                                                            class="mb-0 fw-normal fs-6">
                                                                                            <small
                                                                                                class="text-muted">ผู้สอน</small><br />
                                                                                            {{
                        items
                            .user_detail
                            .user_d_name
                    }}</label>
                                                                                    </div>
                                                                                    <div>
                                                                                        <button type="button"
                                                                                            class="btn btn-success btn-icon-only rounded-circle mb-0 me-2"
                                                                                            @click="
                    add_Teacher(
                        ts_id,
                        items.id
                    )
                        ">
                                                                                            <span
                                                                                                class="btn-inner--icon"><i
                                                                                                    class="bi bi-plus-circle"></i></span>
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
                                            <Bootstrap5Pagination :data="term_sub"
                                                @pagination-change-page="get_Term_sub" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" v-if="!showTeacher">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-0">
                                                เพิ่มอาจารย์ผู้สอนในรายวิชา
                                            </h5>
                                            <p class="text-sm mb-0">
                                                เลือกรายวิชาและเลือกอาจารย์ผู้สอน
                                            </p>
                                        </div>

                                        <div>
                                            <button type="button"
                                                class="btn btn-success btn-icon-only rounded-circle mb-0 me-2"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                <span class="btn-inner--icon"><i class="bi bi-plus-circle"></i></span>
                                            </button>
                                        </div>
                                    </div>
                                    <ul class="list-group list-group-flush mt-4" v-for=" item  in teaching"
                                        :key="item.ts_id">
                                        <li class="list-group-item py-2" v-for=" subTeach  in item.terms_sub_teach"
                                            :key="subTeach.tst_id">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>อาจารย์ผู้สอน:</strong>
                                                    {{
                        subTeach.users
                            .user_detail
                            .user_d_name
                                                    }}
                                                </div>
                                                <div>
                                                    <i class="bi bi-trash3" @click="
                    delete_Teacher(
                        subTeach.tst_id,
                        subTeach.users
                            .user_detail
                            .user_d_name
                    )
                        "></i>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>
<style scoped>
/* Add CSS transitions for a smooth effect */
.col-lg-6,
.col-lg-12 {
    transition: all 0.4s ease;
    /* You can adjust the duration and easing function as needed */
}

.input-search {
    width: 280px !important;
}

.card-menu {
    background-color: #f4f4f4;
}

.p-column-header-content {
    /* margin-left: 50px !important;
    padding-left: 50px !important; */
}
</style>
