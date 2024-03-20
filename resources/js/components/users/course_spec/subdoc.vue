<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { defineProps, defineEmits } from "vue";
import axios from "axios";
import Components_menu from "../../../components/users/course_spec/doc_section_menu.vue";
import Components_fisrt from "../../../components/users/course_spec/doc_section_first.vue";
import Components_learning_result from "../../../components/users/course_spec/doc_section_learning_result.vue";
import Components_planning from "../../../components/users/course_spec/doc_section_planning.vue";
import Components_measure from "../../../components/users/course_spec/doc_section_measure.vue";
import Components_resource from "../../../components/users/course_spec/doc_section_resource.vue";
import Components_committee from "../../../components/users/course_spec/doc_section_committee.vue";
import Components_prep_plan from "../../../components/users/course_spec/doc_section_prep_plan.vue";
import Components_measure_prac from "../../../components/users/course_spec/doc_section_measure_prac.vue";
import Components_adjust from "../../../components/users/course_spec/doc_section_adjust.vue";
import Components_send from "../../../components/users/course_spec/doc_section_send.vue";
const router = useRouter();
let programs = ref([]);
let menu = ref([]);
menu.value = 1;

const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});

const handleMenuClick = (value) => {
    menu.value = value;
};
onMounted(async () => {});
</script>

<template>
    <div class="row mb-5">
        <Components_menu :id="props.id" @selectMenu="handleMenuClick" />
        <Components_fisrt :id="props.id" v-if="menu == 1" />
        <Components_learning_result :id="props.id" v-if="menu == 2" />
        <Components_planning :id="props.id" v-if="menu == 3" />
        <Components_measure :id="props.id" v-if="menu == 4" />
        <Components_resource :id="props.id" v-if="menu == 5" />
        <Components_committee :id="props.id" v-if="menu == 6" />
        <Components_prep_plan :id="props.id" v-if="menu == 7" />
        <Components_measure_prac :id="props.id" v-if="menu == 8" />
        <Components_adjust :id="props.id" v-if="menu == 9" />
        <Components_send :id="props.id" v-if="menu == 10" />
    </div>
</template>

<style>
.text-truncate {
    max-width: 80%;
}
</style>
