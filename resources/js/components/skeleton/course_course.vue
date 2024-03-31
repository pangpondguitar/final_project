<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton from "primevue/skeleton";

const isLoadingData = ref(true);
const products = ref(new Array(2));
</script>

<template>
    <div class="card mt-4">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="mb-0">
                        <Skeleton width="10rem" class="mb-2" height="2rem"></Skeleton>
                    </h5>
                    <p class="text-sm">
                        <Skeleton width="10rem" class="mb-2" height=".4rem"></Skeleton>
                    </p>
                </div>
                <div>
                    <div>
                        <Skeleton width="8rem" class="mb-2" height="1.8rem"></Skeleton>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-lg-12" v-for="item in products">
                    <div class="card bg-gradient-default my-2 ">
                        <div class="card-body m-2">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title text-dark text-gradient">
                                        <Skeleton width="17rem" class="mb-2" height="1.2rem"></Skeleton>
                                    </h5>

                                    <blockquote>
                                        <p class="text-dark ms-3">
                                            <Skeleton width="26rem" class="mb-2" height=".4rem"></Skeleton>
                                        </p>
                                        <footer class="ms-3">
                                            <Skeleton width="10rem" class="mb-2" height=".4rem"></Skeleton>
                                        </footer>
                                    </blockquote>
                                </div>
                                <div>
                                    <Skeleton width="8rem" class="mb-2" height="1.8rem"></Skeleton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>