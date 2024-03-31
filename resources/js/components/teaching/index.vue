<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton_List from "../skeleton/index_list.vue";

const router = useRouter();
let programs = ref([]);
const isLoadingData = ref(true);
const getProgram = async () => {
    try {
        let response = await axios.get("/api/get_all_programs");
        programs.value = response.data.programs;
        console.log("programs", programs.value);
        isLoadingData.value = false;
    } catch (error) {
        console.error("Error fetching programs:", error);
    }
};

const teaching_sub = (id) => {
    router.push("/admin/teaching/teaching_sub/" + id);
};

onMounted(async () => {
    await getProgram();
});
</script>

<template>
    <div v-if="isLoadingData != false" class="mt-4">
        <Skeleton_List />
    </div>
    <div v-else class="row">
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 mb-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">
                                จัดการข้อมูลตารางสอนตามสาขาวิชา
                            </h5>
                            <p class="text-sm">
                                หลักสูตรทั้งหมด (เลือกสาขาวิชา)
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3" v-if="programs.length > 0">
                    <ul
                        class="list-group"
                        v-for="item in programs"
                        :key="item.id"
                    >
                        <li
                            class="list-group-item border-0 d-flex align-items-center px-0 mb-0"
                        >
                            <div class="avatar avatar-sm me-3">
                                <img
                                    src="/public/assets/img/book.png"
                                    alt="kal"
                                    class="border-radius-lg"
                                />
                            </div>
                            <div
                                class="d-flex align-items-start flex-column justify-content-center"
                                @click="courses_all(item.p_id)"
                            >
                                <h6 class="mb-0">{{ item.p_name }}</h6>
                                <p class="mb-0 text-xs text-truncate">
                                    {{ item.p_detail }}
                                </p>
                            </div>
                            <button
                                class="btn btn-link ms-auto text-muted"
                                @click="teaching_sub(item.p_id)"
                            >
                                ดูรายละเอียด
                            </button>
                        </li>
                    </ul>
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
