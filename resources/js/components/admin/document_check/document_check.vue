<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import Skeleton_List from "../../skeleton/list_subject.vue";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
// let programs = ref([]);
const isLoadingData = ref(true);
let terms = ref({});
let currentTerm = ref("");
let subjects = ref("");
let selectedTerm = ref("");
let doc_status = ref({});
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_Terms = async () => {
    try {
        let response = await axios.get(`/api/get_all_terms`);
        terms.value = response.data.terms;
        currentTerm.value = terms.value[0].t_id;
    } catch (error) {
        console.error("Error fetching terms:", error);
    }
};

const getSubject = async () => {
    try {
        let response = await axios.get(`/api/get_subjectAll_term/${props.id}/${currentTerm.value}`);
        subjects.value = response.data.subjects;
        isLoadingData.value = false;
        console.log('subjects', subjects.value);
    } catch (error) {
        console.error('Error fetching subjects:', error);
    }
};

const term = async (event) => {
    const t_id = event.target.value;
    console.log(event.target.value);
    currentTerm.value = t_id;
    await getSubject();
};
const statusDocCheck = (status) => {
    const doc_status = status;

}
const document_check_detail = (id) => {
    router.push('/admin/document_check/document_check_detail/' + id);
};

onMounted(async () => {
    await get_Terms();
    await getSubject();
    await get_doc_status();
});
</script>

<template>
     <div v-if="isLoadingData != false" class="mt-4">
        <Skeleton_List />
    </div>
    <div  v-else class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0"> รายวิชาทั้งหมด</h5>
                            <h4 class="fw-normal text-muted h6">ตรวจสอบรายวิชาในภาคเรียน</h4>
                        </div>
                        <div>
                            <select v-model="selectedTerm" class="form-control select-year" @change="term">
                                <option value="" disabled>Select term</option>
                                <option v-for="item in terms" :key="item.id" :value="item.t_id">{{ item.t_name }} / {{
                                item.t_year }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=" table-responsive">
                    <table class="table align-items-center mb-0 table-hover">
                        <thead>
                            <tr>
                                <th class="  text-sm text-dark  th-1">
                                    รายวิชา
                                </th>
                                <th
                                    class="text-center   text-sm text-dark ">
                                    รหัสวิชา</th>
                                <th
                                    class="text-center   text-sm text-dark ">
                                    สถานะ</th>
                                <th
                                    class="text-center   text-sm text-dark ">
                                    รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="items in subjects" :key="items.ts_id">
                                <td>
                                    <div class="d-flex px-3 py-1 ">

                                        <div class="d-flex flex-column justify-content-center">
                                            <label class="mb-0 ms-0   text-sm ">{{ items.subjects.s_name }}</label>
                                            <p class="text-sm fw-normal  text-muted mb-0 mt-0">รหัสวิชา <span
                                                    class="">{{ items.subjects.s_num }}</span> </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <p class="text-sm fw-normal  text-muted mb-0 mt-0"> <span
                                                    class="">{{ items.subjects.s_num }}</span> </p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <div v-if="items.docfile.length > 0">

                                        <div v-for="docfile in items.docfile" :key="docfile.df_id">
                                            <div v-for="status in docfile.docfile_status.slice(-1)"
                                                :key="status.dfs_id">
                                                <span class="badge bg-gradient-warning shadow"
                                                    v-if="status.dfs_status == '0'">Waiting to check
                                                </span>
                                                <span class="badge bg-gradient-success shadow px-4"
                                                    v-if="status.dfs_status == '1'">Success
                                                </span>
                                                <span class="badge badge-dark text-dark shadow"
                                                    v-if="status.dfs_status == '2'">Make again
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <span class="badge bg-gradient-danger shadow">no documents</span>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div>

                                        <button class=" btn-sm mb-0 btn btn bg-gradient-dark fw-normal px-4"
                                            @click="document_check_detail(items.ts_id)">ดูรายละเอียด</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.text-truncate {
    max-width: 80%;
}

.select-year {
    width: 240px;
    font-size: 16px;
}

.th-1 {
    width: 27% !important;
}
</style>
