<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

import Skeleton from "primevue/skeleton";

const router = useRouter();
let programs = ref([]);
let users = ref([]);
let input = ref("");
const isLoadingData = ref(true);

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
    <div class="row" v-if="isLoadingData">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h5 class="mb-0">ผู้ใช้งาน</h5>
                    <p class="text-sm">ผู้ใช้งานทั้งหมด(อาจารย์)</p>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href=" " class="btn btn-danger"
                                >เพิ่มผู้ใช้งาน
                            </a>
                        </div>
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
                            <tr v-for="item in filteredList()" :key="item.id">
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    username
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                >
                                    email
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    status
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    date
                                </th>
                                <th
                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center"
                                >
                                    Function
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <!-- <img
                                                src="../../../assets/img/kal-visuals-square.jpg"
                                                class="avatar avatar-sm me-3"
                                            /> -->
                                        </div>
                                        <div
                                            class="d-flex flex-column justify-content-center"
                                        >
                                            <h6 class="mb-0"></h6>
                                            <p
                                                class="text-xs text-secondary mb-0"
                                            ></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p
                                        class="text-xs font-weight-bold mb-0"
                                    ></p>
                                    <p class="text-xs text-secondary mb-0">
                                        Organization
                                    </p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span
                                        class="badge badge-sm badge-success bg-success"
                                        >Online</span
                                    >
                                </td>
                                <td class="align-middle text-center">
                                    <span
                                        class="text-secondary text-xs font-weight-bold"
                                    ></span>
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
</template>
<style>
.text-truncate {
    max-width: 80%;
}
</style>
