<script setup>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton_users from "./Skeleton/skeleton_index.vue";

import Paginator from 'primevue/paginator';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional
import { FilterMatchMode } from 'primevue/api';
import PrimeVue from "primevue/config";
import InputText from 'primevue/inputtext';
import IconField from 'primevue/iconfield';
import InputIcon from 'primevue/inputicon';
const router = useRouter();
let programs = ref([]);
let users = ref([]);
let input = ref("");
const isLoadingData = ref(true);
const pagination = ref({
    rows: 10,
    totalRecords: 120,
    rowsPerPageOptions: [10, 20, 30],
});
const filters = ref({
    global: { value: '' }
});

const getProgram = async () => {
    try {
        let response = await axios.get("/api/admin_get_all_programs");
        programs.value = response.data.programs;
        console.log("programs", programs.value);
    } catch (error) {
        console.error("Error fetching programs:", error);
    }
};

const getUserAll = async () => {
    setTimeout(async () => {
        try {
            let response = await axios.get("/api/admin_get_all_users");
            users.value = response.data.users;
            console.log("users", users.value);
            isLoadingData.value = false;
        } catch (error) {
            console.error("Error fetching users:", error);
        }
    }, 1000);
};
const filteredUsers = computed(() => {
    const keyword = filters.value['global'].value.toLowerCase().trim();
    return users.value.filter(user => {
        return user.name.toLowerCase().includes(keyword); // Change 'name' to the field you want to filter
    });
});
const Add_user = (id) => {
    router.push("/admin/users/add_user/");
};
const Edit_user = (id) => {
    router.push("/admin/users/edit_user/" + id);
};

const filteredList = () => {
    return users.value.filter((item) =>
        item.user_detail.user_d_name
            .toLowerCase()
            .includes(input.value.toLowerCase()) ||

        item.user_detail.user_d_name2
            .toLowerCase()
            .includes(input.value.toLowerCase()) ||


        item.user_detail.program.p_name
            .toLowerCase()
            .includes(input.value.toLowerCase())
    );
};

onMounted(async () => {
    await getUserAll();
});
</script>

<template>
    <div v-if="isLoadingData != false">
        <Skeleton_users />
    </div>
    <div class="" v-else>
        <div class="card">
            <div class="card-header px-3 pb-0 pt-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">ผู้ใช้งาน</h5>
                        <p class="text-sm">ผู้ใช้งานทั้งหมด(อาจารย์)</p>
                    </div>
                    <div>
                        <button href=" " class="btn bg-gradient-dark" @click="Add_user()">เพิ่มผู้ใช้งาน +
                        </button>
                    </div>
                </div>

            </div>

            <div class="card-body px-0 pb-1">
                <div class="row pt-0">
                    <div class="col-lg-3 mb-2 px-4 col-sm-3">
                        <div class="flex justify-content-end">
                            <input v-model="input" placeholder="Keyword Search" class="form-control" />
                        </div>
                        <div class="item error" v-if="input && !filteredList().length">
                            <p class="text-sm ms-1 mt-1"> ไม่พบข้อมูล!</p>
                        </div>
                    </div>
                </div>
                <DataTable :value="filteredList()" :paginator="true" :rows="pagination.rows"
                    :rowsPerPageOptions="[5, 10, 20, 50]" :showGridlines="true" v-model:filters="filters">

                    <Column header="Name" :style="{ width: '25%' }">
                        <template v-slot:body="{ data }">
                            <div :style="{ width: '300px' }">

                            </div>
                            <div class="d-flex">
                                <div v-if="data.user_detail.user_d_pic != ''">
                                    <img :src="'/uploads/profile_pic/' + data.user_detail.user_d_pic"
                                        class="avatar avatar-sm me-3" />
                                </div>
                                <div v-else>
                                    <img src="../../../../../public/assets/img/user.png"
                                        class="avatar avatar-sm me-3" />
                                </div>

                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">{{ data.user_detail.user_d_name }}</h6>
                                    <p class="text-xs text-secondary mb-0">{{ data.user_detail.user_d_name2 }}</p>
                                </div>
                            </div>

                        </template>
                    </Column>
                    <Column field="user_detail.user_d_name2" header="Contact">
                        <template v-slot:body="{ data }">
                            <p class="text-xs    text-secondary mb-0" :style="{ width: '150px' }">
                                {{ data.user_detail.user_d_phone }} <br>
                                {{ data.email }}
                            </p>

                        </template>
                    </Column>
                    <Column field="user_detail.user_d_name2" header="Position">
                        <template v-slot:body="{ data }">
                            <p class="text-sm text-secondary mb-0">
                            <div v-if="data.user_type == 2">
                                <span class="badge badge-sm bg-gradient-dark  px-3">Teacher</span>
                            </div>
                            <div v-if="data.user_type == 3">
                                <span class="badge badge-sm bg-gradient-warning  px-3">President</span>
                            </div>
                            <div v-if="data.user_type == 4">
                                <span class="badge bg-gradient-danger  px-3 ">Manager</span>
                            </div>
                            </p>
                        </template>
                    </Column>
                    <Column field="user_detail.user_d_name2" header="Program">
                        <template v-slot:body="{ data }">
                            <div :style="{ width: '190px' }">
                                <label class="text-sm  fw-normal text-muted text-center mb-0">
                                    {{ data.user_detail.program.p_name }}
                                </label>
                            </div>

                        </template>

                    </Column>
                    <Column field="user_detail.user_d_name2" header="Controllor">
                        <template v-slot:body="{ data }">
                            <div :style="{ width: '100px' }">
                                <a class="text-secondary font-weight-bold ms-3" data-toggle="tooltip"
                                    @click="Edit_user(data.id)">
                                    <i class="bi bi-pen"></i>
                                </a>
                                <a class="text-danger font-weight-bold ms-4" data-toggle="tooltip"
                                    data-original-title="Edit user" data-target="">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </div>





</template>
<style>
/* กำหนดรูปแบบตัวอักษรแบบ Kanit ให้กับทั้ง DataTable */
.p-datatable {
    font-family: 'Kanit', sans-serif;
}

/* กำหนดรูปแบบตัวอักษรแบบ Kanit ให้กับคอลัมน์ 'Name' */
.column-name {
    font-family: 'Kanit', sans-serif;
}

thead,
tbody,
tfoot,
tr,
td,
th {

    border-bottom: solid #eaeaea 1px !important;
}

.p-dropdown-items {
    padding: 0px !important;
}
</style>