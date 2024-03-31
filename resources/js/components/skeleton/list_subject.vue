<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton from "primevue/skeleton";

const isLoadingData = ref(true);
const products = ref(new Array(7));
</script>

<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <Skeleton
                        class="mb-2"
                        width="10%"
                        height="1.5rem"
                        borderRadius="6px"
                    ></Skeleton>
                    <Skeleton
                                                    width="10rem"
                                                    class="mb-2"
                                                    height=".4rem"
                                                ></Skeleton>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <tbody>
                            <tr class="" v-for="item in products">
                                <td class="py-2" width="300px">
                                    <div class="d-flex ms-3">
                                        <div class="d-flex">
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
    </div>
</template>
