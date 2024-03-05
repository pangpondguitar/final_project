<script setup>
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
const router = useRouter();
import { defineProps, defineEmits } from 'vue';
// let programs = ref([]);
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
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header px-3 py-3">
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
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 td-doc">
                                รายวิชา
                            </th>

                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                สถานะ</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="items in subjects" :key="items.ts_id">
                            <td>
                                <div class="d-flex px-3 ">

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 fw-semibold">{{ items.subjects.s_name }}</h6>
                                        <p class="text-sm fw-normal  text-secondary mb-0">รหัสวิชา <span
                                                class="text-success">{{ items.subjects.s_num }}</span> </p>
                                    </div>
                                </div>
                            </td>

                            <td class="align-middle text-center text-sm">
                                <div v-if="items.docfile.length > 0">

                                    <div v-for="docfile in items.docfile" :key="docfile.df_id">
                                        <div v-for="status in docfile.docfile_status.slice(-1)" :key="status.dfs_id">
                                            <span class="badge badge-warning text-warning"
                                                v-if="status.dfs_status == '0'">Waiting to check
                                            </span>
                                            <span class="badge badge-success text-success"
                                                v-if="status.dfs_status == '1'">Success
                                            </span>
                                            <span class="badge badge-dark text-dark"
                                                v-if="status.dfs_status == '2'">Make again
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger text-danger">no documents</span>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div>

                                    <button class="btn btn-light btn-sm mb-0"
                                        @click="document_check_detail(items.ts_id)">ดูรายละเอียด</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style>
.text-truncate {
    max-width: 80%;
}

.select-year {
    width: 240px;
    font-size: 16px;
}

.th-1 {
    width: 45%;
}

.td-doc {
    width: 50%;
}
</style>
