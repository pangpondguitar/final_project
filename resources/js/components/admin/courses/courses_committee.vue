<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { defineComponent } from 'vue'
import { Carousel, Navigation, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
let teachers = ref({});
let committee = ref({});
const props = defineProps({
    id: {
        type: String,
        default: "",
    },
});
const get_teachers = async () => {
    try {
        let response = await axios.get(`/api/admin_get_teacher/${props.id}`);
        teachers.value = response.data.teachers;
    } catch (error) {
        console.error("Error fetching teachers:", error);
    }
};
const get_Committee = async () => {
    try {
        let response = await axios.get(`/api/admin_get_committee/${props.id}`);
        committee.value = response.data.committee;
    } catch (error) {
        console.error("Error fetching committee:", error);
    }
};
const addCommittee = (id) => {
    axios
        .post(`/api/admin_add_committee/${props.id}/${id}`)
        .then((response) => {
            get_Committee();
            get_teachers();
        })
        .catch((error) => { });

    toast.fire({
        icon: "success",
        title: "Week hour add successfully",
    });
};

const deleteCommittee = (id) => {
    Swal.fire({
        title: "ยืนยันลบข้อมูล",
        text: 'ยืนยันลบข้อมูล',
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ยืนยันรายการ",
        cancelButtonText: "ยกเลิก",
    }).then((result) => {
        if (result.value) {
            axios
                .get("/api/admin_delete_committee/" + id)
                .then(() => {
                    Swal.fire(
                        "Delete",
                        "Subject delete successfully",
                        "success"
                    );
                    get_Committee();
                    get_teachers();
                })
                .catch(() => {
                    Swal.fire(
                        "Failed!!",
                        "There was somthing wrong",
                        "Warning"
                    );
                });
        }
    });
};
onMounted(async () => {
    await get_teachers();
    await get_Committee();
});
</script>

<template>
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header pb-0 p-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">คณะกรรมการหลักสูตร</h5>
                        <p class="text-sm">คณะกรรมการหลักสูตรทั้งหมด</p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" v-if="committee.length > 0">
                    <div class="col-lg-3" v-for="item in committee" :key="item.id">
                        <div class="card card-plain text-center ">

                            <div class="d-flex justify-content-end">
                                <div><i class="bi bi-trash3 text-decondary me-4"
                                        @click="deleteCommittee(item.cm_id)"></i>
                                </div>
                            </div>
                            <a href="javascript:;">
                                <img class="img-icon-commit " src=" /public/assets/img/man (1).png">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{ item.user.user_detail.user_d_name }}</h5>
                                <h6 class="category text-info text-gradient">{{ item.user.user_detail.user_d_name2
                                    }}</h6>
                                <p class="card-description">
                                    "Don't walk behind me; I may not lead. Don't walk in front of me; I may not
                                    follow.
                                    Just
                                    walk beside me and be my friend."
                                </p>

                            </div>
                        </div>
                    </div>


                    <!-- <div class="col-lg-3">
                        <div class="card h-100 card-plain border" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <div class="card-body d-flex flex-column justify-content-center text-center">
                                <a href="javascript:;">
                                    <i class="fa fa-plus text-secondary mb-3" aria-hidden="true"></i>
                                    <h5 class=" text-secondary"> เพิ่มกรรมการ </h5>
                                </a>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="" v-if="committee.length == 0">
                    <div class="d-flex justify-content-center">

                        <img class="img-committ-not " src=" /public/assets/img/not-result.jpg">


                    </div>
                    <div class="d-flex justify-content-center text-center">

                        <div>
                            <h5>ยังไม่มีคณะกรรมการหลักสูตรในขณะนี้</h5>
                            <label for="" class="text-muted mb-5">กรุณาเพิ่มข้อมูล</label>
                        </div>


                    </div>
                </div>

            </div>

        </div>
    </div>
    <Carousel :items-to-show="5" :wrap-around="true" v-if="teachers.length > 0">
        <Slide v-for="item in teachers" :key="item.id">
            <div class="carousel__item">
                <div class="card card-plain text-center py-4 h-100 mx-2 bg-white">
                    <a href="javascript:;">
                        <img class="img-icon-commit " src=" /public/assets/img/man (1).png">
                    </a>
                    <div class="card-body">
                        <label class="card-title fw-normal h6">{{ item.user_detail.user_d_name }}</label><br>
                        <span class="text-muted">{{ item.user_detail.user_d_name2 }}</span>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <button class="btn btn-dark col-6" @click="addCommittee(item.id)">เพิ่ม</button>
                    </div>
                </div>
            </div>
        </Slide>

        <template #addons>
            <Navigation />
        </template>
    </Carousel>


</template>


<style>
.img-icon-commit {
    width: 50px;
}

.carousel__slide {
    scroll-snap-stop: auto;
    flex-shrink: 0;
    margin: 0;
    position: relative;
    display: flow !important;
    justify-content: center;
    align-items: center;
    transform: translateZ(0);
}

.img-committ-not {
    width: 30%;
}
</style>
