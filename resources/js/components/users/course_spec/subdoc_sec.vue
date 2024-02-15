
<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
let programs = ref([]);

const getProgram = async () => {
    try {
        let response = await axios.get("/api/get_all_programs");
        programs.value = response.data.programs;
        console.log('programs', programs.value);
    } catch (error) {
        console.error('Error fetching programs:', error);
    }
};

const teaching_sub = (id) => {
    router.push('/admin/teaching/teaching_sub/' + id);
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

            </div>
        </div>
    </div>
</template>
<style>
.text-truncate {
    max-width: 80%;
}
</style>


