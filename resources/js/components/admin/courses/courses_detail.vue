
<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

import Components_menu from '../../../components/admin/courses/courses_menu.vue'
import Components_subject from '../../../components/admin/courses/courses_subject.vue'
import Components_commmittee from '../../../components/admin/courses/courses_committee.vue'
import Components_edit from '../../../components/admin/courses/courses_edit.vue'
import Components_doc from '../../../components/admin/courses/courses_doc.vue'

const router = useRouter();
let programs = ref([]);
let menu = ref([]);
menu.value = 1
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const update_course = () => {
    const formData = new FormData();
    formData.append("c_name", form.value.c_name);
    formData.append("c_name2", form.value.c_name2);
    formData.append("id", props.id);
    axios
        .post(`/api/admin_update_course/`, formData)
        .then((response) => {
            form.value.c_name = '',
                form.value.c_name2 = ''
            get_course_detail();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Subject add successfully",
    });
};

const courses_all = (id) => {
    router.push('/admin/courses/courses_all/' + id);
};
const handleMenuClick = (value) => {
    console.log('Menu clicked with value:', value);
    menu.value = value
};

onMounted(async () => {

});
</script>

<template>
    <div class="row">
        <Components_menu @selectMenu="handleMenuClick" />
        <Components_subject :id="props.id" v-if="menu == 1" />
        <Components_commmittee :id="props.id" v-if="menu == 2" />
        <Components_edit :id="props.id" v-if="menu == 3" />
        <Components_doc v-if="menu == 4" :id="props.id" />
    </div>
</template>
<style>
.text-truncate {
    max-width: 80%;
}
</style>


