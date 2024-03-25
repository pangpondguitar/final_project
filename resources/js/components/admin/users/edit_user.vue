<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton_users from "./Skeleton/skeleton_index.vue";
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
    }, 2000);
};

const courses_all = (id) => {
    router.push("/admin/courses/courses_all/" + id);
};

const filteredList = () => {
    return users.value.filter((item) =>
        item.user_detail.user_d_name
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
    <div class="row" v-else>
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header px-3 pb-0 pt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">ผู้ใช้งาน</h5>
                            <p class="text-sm">ผู้ใช้งานทั้งหมด(อาจารย์)</p>
                        </div>
                        <div>
                            <a href=" " class="btn bg-gradient-dark"
                                >เพิ่มผู้ใช้งาน +
                            </a>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="">ค้นหาชื่ออาจารย์</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Search..."
                                v-model="input"
                            />
                            <div
                                class="item error"
                                v-if="input && !filteredList().length"
                            >
                                <p>ไม่พบข้อมูล!</p>
                            </div>
                            <!-- เพิ่ม form การค้นหา -->
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    username
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    program
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    position
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    Contact
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    Controllor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in filteredList()" :key="item.id">
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img
                                                src="../../../../../public/assets/img/bruce-mars.jpg"
                                                class="avatar avatar-sm me-3"
                                            />
                                        </div>
                                        <div
                                            class="d-flex flex-column justify-content-center"
                                        >
                                            <h6 class="mb-0 text-sm">
                                                {{
                                                    item.user_detail.user_d_name
                                                }}
                                            </h6>
                                            <p
                                                class="text-xs text-secondary mb-0"
                                            >
                                                {{
                                                    item.user_detail
                                                        .user_d_name2
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="align-middle text-start"> 
                                    <p class="text-xs    text-secondary mb-0">
                                        {{ item.user_detail.user_d_phone }} <br> 
                                        {{ item.email }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm text-secondary mb-0">
                                        <div v-if="item.user_type == 2">
                                            <span class="badge badge-sm bg-gradient-dark  px-3" >Teacher</span>
                                        </div>
                                        <div v-if="item.user_type == 3">
                                            <span class="badge badge-sm bg-gradient-warning  px-3" >President</span>
                                        </div>
                                        <div v-if="item.user_type == 4">
                                            <span class="badge bg-gradient-danger  px-3 " >Manager</span>
                                        </div>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <label class="text-sm  fw-normal text-muted text-center mb-0">
                                        {{ item.user_detail.program.p_name }}
                                    </label>
                                </td>
                                <td class="align-middle text-center">
                                    <a
                                        href=" "
                                        class="text-secondary font-weight-bold ms-3"
                                        data-toggle="tooltip"
                                    >
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    <a
                                        class="text-danger font-weight-bold ms-4"
                                        data-toggle="tooltip"
                                        data-original-title="Edit user"
                                        data-target=""
                                    >
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <Paginator
            :rows="10"
            :totalRecords="120"
            :rowsPerPageOptions="[10, 20, 30]"
        ></Paginator>
    </div>
</template>
<style>
.text-truncate {
    max-width: 80%;
}
</style>
