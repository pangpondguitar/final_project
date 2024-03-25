<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton from "primevue/skeleton";

const isLoadingData = ref(true);
const products = ref(new Array(8));
</script>

<template>
    <div class="row">
        <div class="col-lg-12 mt-4">
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <tbody>
                            <tr class="" v-for="item in products">
                                <td class="py-2" width="300px">
                                    <div class="d-flex ms-3">
                                        <div class="d-flex">
                                            <Skeleton
                                                shape="circle"
                                                size="2.9rem"
                                                class="mr-2"
                                            ></Skeleton>
                                            <div class="ms-3 mt-1">
                                                <Skeleton
                                                    class="mb-2"
                                                    width="50%"
                                                    height="0.5rem"
                                                    borderRadius="16px"
                                                ></Skeleton>
                                                <Skeleton
                                                    width="10rem"
                                                    class="mb-2"
                                                    height=".4rem"
                                                ></Skeleton>
                                                <Skeleton
                                                    height=".2rem"
                                                ></Skeleton>
                                            </div>
                                        </div>
                                        <div>
                                            <Skeleton
                                                class="mb-2"
                                                width="50%"
                                                height="0.5rem"
                                                borderRadius="16px"
                                            ></Skeleton>
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <div class="d-flex justify-content-center">
                                        <Skeleton
                                            class=""
                                            width="50%"
                                            height="0.5rem"
                                            borderRadius="16px"
                                        ></Skeleton>
                                    </div>
                                </td>
                                <td class="">
                                    <div class="d-flex justify-content-center">
                                        <Skeleton
                                            class=""
                                            width="50%"
                                            height="0.5rem"
                                            borderRadius="16px"
                                        ></Skeleton>
                                    </div>
                                </td>
                                <td class="">
                                    <div class="d-flex justify-content-center">
                                        <Skeleton
                                            class=""
                                            width="50%"
                                            height="0.5rem"
                                            borderRadius="16px"
                                        ></Skeleton>
                                    </div>
                                </td>
                                <td class="">
                                    <div class="d-flex justify-content-center">
                                        <Skeleton
                                            class=""
                                            width="50%"
                                            height="0.5rem"
                                            borderRadius="16px"
                                        ></Skeleton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                    <div class="d-flex">
                        <Skeleton size="4rem" class="me-2 mb-2"></Skeleton>
                        <div class="align-self-start mt-1" style="flex: 1">
                            <Skeleton width="50%" class="mb-2"></Skeleton>
                            <Skeleton width="75%"></Skeleton>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</template>
