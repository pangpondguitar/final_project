<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { defineProps, defineEmits } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
const router = useRouter();
let menu = ref([]);
let resource = ref({});
let editor = ClassicEditor
const editMode = ref(false);
let editorConfig = ref('')


let form = ref({
    id: '',
    title: '<p>Content of the editor.</p>'
});

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const getMeasure_list = async () => {
    try {
        let response = await axios.get(`/api/user_get_measure/${props.id}`);
        measure.value = response.data.measure;
    } catch (error) {
        console.error('Error fetching measure:', error);
    }
};

const addResource = () => {
    const formData = new FormData();
    formData.append("editor", editorData.value);
    axios
        .post(`/api/user_add_resource/${props.id}`, formData)
        .then((response) => {
            editorData.value = ''
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};
const getEditor = async () => {
    try {
        let response = await axios.get(`/api/user_get_resource/${props.id}`);
        resource.value = response.data.resource;
        editMode.value = resource.value != null;
        if (editMode.value == true) {
            form.value.id = resource.value.rs_id
            form.value.title = resource.value.rs_title
        }
    } catch (error) {
        console.error('Error fetching getEditor:', error);
    }
};
const editor_formCheck = async () => {
    try {
        if (editMode.value == true) {
            const formData = new FormData();
            console.log(form.value.id);
            console.log(form.value.title);
            formData.append("id", form.value.id);
            formData.append("editor", form.value.title);
            axios
                .post(`/api/user_update_resource`, formData)
                .then((response) => {
                    form.id.value = ''
                    form.title.value = ''
                    getEditor();
                })
                .catch((error) => { });

            toast.fire({
                icon: "success",
                title: "Update Planing update successfully",
            });
        } else {
            const formData = new FormData();
            console.log(form.value.id);
            console.log(form.value.title);
            formData.append("editor", form.value.title);
            axios
                .post(`/api/user_add_resource/${props.id}`, formData)
                .then((response) => {
                    form.title.value = ''
                    getEditor()
                })
                .catch((error) => { });

            toast.fire({
                icon: "success",
                title: "Week hour add successfully",
            });
        }
    } catch (error) {
        console.error('Error submitting data:', error);
    }
};


onMounted(async () => {
    await getEditor();
});
</script>
<template>
    <div class="col-lg-9 ">
        <div class="card " id="basic-info">
            <div class="card-header pb-0">
                <div>
                    <h5 class="mb-0">ทรัพยากรประกอบการเรียนการสอน</h5>
                    <label class=" mb-0 ms-0 text-muted">ทรัพยากรประกอบการเรียนการสอน
                    </label>
                </div>
            </div>
            <div class="card-body">
                <ckeditor :editor="editor" v-model="form.title" :config="editorConfig"></ckeditor>

                <button class="mt-3 btn btn-dark" @click="editor_formCheck()">บันทึกข้อมูล</button>
            </div>
        </div>
    </div>
</template>


<style>
.ck-editor__editable_inline {
    min-height: 230px;
}
</style>
