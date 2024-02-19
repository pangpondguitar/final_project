
<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { defineProps, defineEmits } from 'vue';
import axios from 'axios';
import Components_menu from '../../../components/users/course_spec/doc_section_menu.vue';
import Components_fisrt from '../../../components/users/course_spec/doc_section_first.vue';
import Components_learning_result from '../../../components/users/course_spec/doc_section_learning_result.vue';
import Components_planning from '../../../components/users/course_spec/doc_section_planning.vue';
import Components_measure from '../../../components/users/course_spec/doc_section_measure.vue';
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

const handleMenuClick = (value) => {
    menu.value = value
};
onMounted(async () => {

});
</script>

<template>
    <div class="row mb-5">
        <Components_menu @selectMenu="handleMenuClick" />
        <Components_fisrt :id="props.id" v-if="menu == 1" />
        <Components_learning_result :id="props.id" v-if="menu == 2" />
        <Components_planning :id="props.id" v-if="menu == 3" />
        <Components_measure :id="props.id" v-if="menu == 4" />
    </div>
</template>
<style>
.text-truncate {
    max-width: 80%;
}
</style>


