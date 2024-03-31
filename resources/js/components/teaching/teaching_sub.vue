<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import Skeleton_teacher_sub from "./Skeleton/teacher_sub.vue";
import Skeleton_term_sub from "./Skeleton/term_sub.vue";
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
let selectedTerm = ref("");
let term2 = ref({});
let terms = ref([]);
let subject = ref([]);
let teachers = ref([]);
let teaching = ref([]);
let menu = ref({});
let currentTerm = ref("");
let term_sub = ref([]);
let ts_id = ref({});
let input = ref("");
let input2 = ref("");
let single_term = ref("");
const isLoadingData = ref(true);
const isLoadingData_first = ref(true);
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
const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        currentTerm.value = terms.value[0].t_id;
        get_Terms_ById(currentTerm.value);
        console.log('term', terms.value);
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};
const get_Terms_ById = async (id) => {
    try {
        let response = await axios.get(`/api/get_single_term/${id}`);
        single_term.value = response.data.single_term;
        console.log('single_term', single_term.value);
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};
const openRemarkModal = (item) => {
    isLoadingData.value = true;
    get_all_Teaching(item.ts_id);
    form.value.title = item.subjects.s_name
    form.value.id = item.ts_id
    modalremark.value = true;
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



const get_Term_sub = async () => {
    try {
        let response = await axios.get(
            `/api/get_term_sub/${currentTerm.value}/${props.id}`
        );
        term_sub.value = response.data.term_sub;
        console.log('term_sub', term_sub.value);
        isLoadingData_first.value = false;
    } catch (error) {
        console.error("Error fetching term_sub:", error);
    }
};
const get_all_Teaching = async (ts_id) => {
    try {
        console.log(ts_id);
        let response = await axios.get(`/api/get_all_teaching/${ts_id}`);
        teaching.value = response.data.teaching;
        get_all_Teacher();
    } catch (error) {
        console.error("Error fetching teaching:", error);
    }
};

const get_all_Teacher = async () => {
    try {
        let response = await axios.get(`/api/get_all_teachers/${props.id}`);
        teachers.value = response.data.teachers;
        checkedItemsteach.value = [];

        teachers.value.forEach((item) => {
            if (Array.isArray(teaching.value) &&
                teaching.value.length > 0
            ) {
                const foundInMark = teaching.value.some(
                    (markItem) => item.id.toString() === markItem.id
                );
                console.log(foundInMark);
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
        isLoadingData.value = false;
        console.log('check', checkedItemsteach.value);

    } catch (error) {
        console.error("Error fetching teachers:", error);
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

const term = (event) => {
    const t_id = event.target.value;
    currentTerm.value = t_id;
    get_Terms_ById(t_id);
    get_Subject();
    get_Term_sub();
};
const menus = (menu_type) => {
    menu.value = menu_type;
};
const menus_check = (menu_type) => {
    menu.value = menu_type;
    showTeacher.value = true;

};



const add_Subjects = () => {
    const formData = new FormData();
    checkedItems.value.forEach((item) => {
        formData.append("subjectsId[]", item);
    });
    axios
        .post(`/api/add_subjects/${currentTerm.value}/${props.id}`, formData)
        .then((response) => {
            get_Subject();
        })
        .catch((error) => { });
    toast.fire({
        icon: "success",
        title: "List Result add successfully",
    });
};

const add_Teachers = (id) => {
    console.log(id);
    const formData = new FormData();
    checkedItemsteach.value.forEach((item) => {
        formData.append("userId[]", item);
    });
    axios
        .post(`/api/add_teacher_sub/${id}`, formData)
        .then((response) => {
            $("#ModalRemark").modal("hide");
        })
        .catch((error) => { });
    toast.fire({
        icon: "success",
        title: "Add Teachers Subject successfully",
    });
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


const filteredListSubject = () => {
    return subject.value.filter((item) =>
        item.s_name
            .toLowerCase()
            .includes(input.value.toLowerCase())
    );
};
const filteredListTermSubject = () => {
    return term_sub.value.filter((item) =>
        item.subjects.s_name
            .toLowerCase()
            .includes(input2.value.toLowerCase()) ||
        item.subjects.s_num
            .toLowerCase()
            .includes(input2.value.toLowerCase())
    );
};
const updateCheckedItems = () => {
    console.log("Checked Items:", checkedItems.value);
};
const updateCheckedItems2 = () => {
    console.log("Checked Items:2", checkedItemsteach.value);
};
onMounted(async () => {
    await get_Program();
    await get_Terms();
    await get_Subject();
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
                            <h1 class="modal-title fs-5  mb-0 pb-0 " id="ModalRemark">
                                เพิ่มอาจารย์ผู้สอนในรายวิชา
                            </h1>
                            <p class="py-0 ps-0  ms-0 text-muted text-sm mb-1">{{ form.title }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-body py-0 px-0">
                    <div class="row py-0">
                        <div class="col-lg-12">
                            <div v-if="isLoadingData != false">
                                <Skeleton_teacher_sub />
                            </div>
                            <ul v-else class="list-group list-group-flush">
                                <li class="list-group-item  " v-for="item in teachers" :key="item.id">
                                    <div class="d-flex justify-content-between mx-2 py-1 align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <div v-if="item.user_detail.user_d_pic != ''">
                                                    <img :src="'/uploads/profile_pic/' + item.user_detail.user_d_pic"
                                                        class="avatar avatar-sm me-2" />
                                                </div>
                                                <div v-else>
                                                    <img :src="'/assets/img/user.png'" class="avatar avatar-sm me-2" />
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <label for="" class="text-sm mb-0"> {{
                                item.user_detail.user_d_name }}
                                                </label>
                                                <label for=""
                                                    class="text-sm fw-normal text-muted mb-0">ชื่ออาจารย์ผู้สอน
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    v-model="checkedItemsteach" @change="updateCheckedItems2"
                                                    :value="item.id" />
                                            </div>
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
                        @click="add_Teachers(form.id)">
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="isLoadingData_first != false">
        <Skeleton_term_sub />
    </div>
    <div class="row" v-else>
        <div class="col-12 mt-4">
            <h4 class="mb-0">{{ program.p_name }}</h4>
            <p class="text-sm"> การบริหารจัดการข้อมูลเกี่ยวกับการจัดการเรียนการสอนสาหรับอาจารย์
                ในของปีการศึกษาภาคเรียนนั้นๆ</p>
        </div>
        <div class="col-12 mt-3">

            <div class="card mb-4 pb-3">
                <div class="card-header pb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0" v-if="menu === 'Add'">
                                เพิ่มรายวิชาปีการศึกษา {{ single_term.t_name }} / {{ single_term.t_year }}
                            </h5>
                            <h5 class="mb-0" v-else>
                                รายวิชาทั้งหมดในปีการศึกษา {{ single_term.t_name }} / {{ single_term.t_year }}
                            </h5>
                            <p class="text-sm">
                                เลือกรายวิชาต่างๆและเลือกอาจารย์
                            </p>
                        </div>

                        <div>
                            <select v-model="selectedTerm" class="form-control select-year " @change="term">
                                <option value="" disabled>เลือกปีการศึกษา</option>
                                <option v-for="item in terms" :key="item.id" :value="item.t_id" class="">{{ item.t_name
                                    }} / {{
                                item.t_year }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div v-if="menu === 'Add'">
                    <div class="card-body py-0 pb-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <input type="text" v-model="input" class="form-control input-search shadow"
                                            placeholder="ค้นหารายวิชา..." />
                                        <div class="item fruit" v-for=" item  in  filteredListSubject() " :key="item">
                                        </div>
                                        <div class="item error" v-if="input && !filteredListSubject().length">
                                            <p>No results found!</p>
                                        </div>
                                    </div>
                                    <div>
                                        <button class="btn btn-light s-none me-2 text-sm" @click="menus('All')">
                                            รายวิชาทั้งหมด
                                        </button>
                                        <button class="btn bg-gradient-dark fw-normal text-sm"
                                            @click="menus_check('Add')">
                                            เพิ่มรายวิชา
                                        </button>
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
                        <div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <input type="text" v-model="input2" class="form-control input-search shadow"
                                        placeholder="ค้นหารายวิชา..." />
                                    <div class="item fruit" v-for=" item  in  filteredListTermSubject() " :key="item">
                                    </div>
                                    <div class="item error" v-if="input2 && !filteredListTermSubject().length">
                                        <p>No results found!</p>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-light s-none me-2 text-sm shadow " @click="menus('All')">
                                        รายวิชาทั้งหมด
                                    </button>
                                    <button class="btn bg-gradient-dark fw-normal text-sm shadow"
                                        @click="menus_check('Add')">
                                        เพิ่มรายวิชา
                                    </button>
                                </div>


                            </div>


                        </div>
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
