<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton from "primevue/skeleton";

const isLoadingData = ref(true);
const products = ref(new Array(6));
</script>

<template>
    <div class="card mb-4 mt-4">
        <div class="card-header pb-0 mb-0">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="mb-0">
                        <Skeleton width="10rem" class="mb-2" height=".4rem"></Skeleton>
                    </h5>
                    <p class="text-sm">
                        <Skeleton width="10rem" class="mb-2" height=".4rem"></Skeleton>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <ul class="list-group" v-for="item in products">
                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">

                    <div class="d-flex justify-content-between ms-3 py-1">
                        <div class="d-flex">
                            <Skeleton size="2.4rem" class="mr-2"></Skeleton>
                            <div class="ms-3 mt-1">
                                <Skeleton class="mb-2" width="60%" height="0.6rem" borderRadius="16px">
                                </Skeleton>
                                <Skeleton width="18rem" class="mb-2" height=".4rem"></Skeleton>
                            </div>

                        </div>

                    </div>

                </li>
            </ul>
        </div>
    </div>
</template>