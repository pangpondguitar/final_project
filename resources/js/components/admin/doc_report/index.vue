<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const router = useRouter();
let programs = ref([]);

const getProgram = async () => {
    try {
        let response = await axios.get("/api/admin_get_all_programs");
        programs.value = response.data.programs;
        console.log("programs", programs.value);
    } catch (error) {
        console.error("Error fetching programs:", error);
    }
};

const courses_all = (id) => {
    router.push("/admin/doc_report/doc_report/" + id);
};

onMounted(async () => {
    await getProgram();
});
</script>

<template>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">หลักสูตร</h5>
                            <p class="text-sm">หลักสูตรทั้งหมด</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3" v-if="programs.length > 0">
                    <ul
                        class="list-group"
                        v-for="item in programs"
                        :key="item.id"
                    >
                        <li
                            class="list-group-item border-0 d-flex align-items-center px-0 mb-2"
                        >
                            <div class="avatar me-3">
                                <img
                                    src="/public/assets/img/book (5).png"
                                    alt="kal"
                                    class="border-radius-lg shadow"
                                    style="padding: 8px"
                                />
                            </div>
                            <div
                                class="d-flex align-items-start flex-column justify-content-center"
                            >
                                <h6 class="mb-0">{{ item.p_name }}</h6>
                                <p class="mb-0 text-xs text-truncate">
                                    {{ item.p_detail }}
                                </p>
                            </div>
                            <button
                                class="btn btn-link pe-3 ps-0 mb-0 ms-auto"
                                @click="courses_all(item.p_id)"
                            >
                                ดูข้อมูล
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
