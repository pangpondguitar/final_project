

<script setup>
import { defineProps, defineEmits } from 'vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

let menu = ref([]);
const props = defineProps(['id']);
const emits = defineEmits();
menu.value = 1
const select_menu = (value) => {
    menu.value = value
    emits('selectMenu', menu.value);
};
</script>
<template>
    <h5 class="mb-0">จัดการข้อมูลหลักสูตร</h5>
    <p class="text-sm">จัดการข้อมูลหลักสูตร</p>

    <div class="col-lg-12 mb-3">
        <div class="row">
            <div class="col-lg-3  ">
                <div class="card h-100 card-menu " @click="select_menu(1)" :class='{ "menu-active": menu === 1 }'>
                    <span class="mask  opacity-9 border-radius-xl  "></span>
                    <div class="card-body p-3 position-relative">
                        <div class="row">
                            <div class="col-8 text-start">
                                <h5 class="title fw-normal mb-0 mt-3 ">
                                    รายวิชาทั้งหมดในหลักสูตร
                                </h5>
                                <span class="title text-sm">รายวิชาทั้งหมด </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 ">
                <a>
                    <div class="card h-100  " @click="select_menu(2)" :class='{ "menu-active": menu === 2 }'>
                        <span class="mask  opacity-9 border-radius-xl  "></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <h5 class="title fw-normal mb-0 mt-3">
                                        คณะกรรมการหลักสูตร
                                    </h5>
                                    <span class="text-muted text-sm title">คณะกรรมการหลักสูตร </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 ">
                <a>
                    <div class="card h-100 card-menu " @click="select_menu(3)" :class='{ "menu-active": menu === 3 }'>
                        <span class="mask  opacity-9 border-radius-xl  "></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <h5 class="title fw-normal mb-0 mt-3">
                                        รายละเอียดข้อมูลหลักสูตร
                                    </h5>
                                    <span class="title text-sm">รายละเอียดข้อมูลหลักสูตร </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 ">
                <a>
                    <div class="card h-100 card-menu " @click="select_menu(4)" :class='{ "menu-active": menu === 4 }'>
                        <span class="mask  opacity-9 border-radius-xl  "></span>
                        <div class="card-body p-3 position-relative">
                            <div class="row">
                                <div class="col-8 text-start">
                                    <h5 class="title fw-normal mb-0 mt-3">
                                        รายละเอียดข้อมูล มคอ.
                                    </h5>
                                    <span class="title text-sm">จัดการข้อมูล มคอ. </span>
                                </div>

                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>



<style>
.card-menu {
    border: #000 !important;
}

.menu-active {
    box-shadow: rgb(191 56 109 / 19%) 0px 13px 27px -5px, rgb(165 31 117 / 9%) 0px 8px 16px -8px;
    color: #fff !important;
    background: linear-gradient(135deg, #F36265 0%, #961276 100%);
}

.menu-active .title {
    color: #fff !important;

}
</style>
