<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Skeleton from "primevue/skeleton";

const isLoadingData = ref(true);
const products = ref(new Array(8));
</script>

<template>
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <Skeleton class="mb-2" width="18%" height="2rem" borderRadius="8px"></Skeleton>
            <Skeleton class="mb-2" width="12%" height="0.6rem" borderRadius="8px"></Skeleton>
        </div>
        <div class="card-body pt-0">
            <table class="table align-items-center mb-0">
                <tbody>
                    <tr class="" v-for="item in products">
                        <td class="py-2" width="89%">
                            <div class="d-flex ms-3 py-1">
                                <div class="d-flex">
                                    <Skeleton shape="circle" size="2.4rem" class="mr-2"></Skeleton>
                                    <div class="ms-3 mt-1">
                                        <Skeleton class="mb-2" width="50%" height="0.5rem" borderRadius="16px">
                                        </Skeleton>
                                        <Skeleton width="10rem" class="mb-2" height=".4rem"></Skeleton>
                                    </div>
                                </div>
                                <div>
                                    <Skeleton class="mb-2" width="50%" height="0.4rem" borderRadius="16px">
                                    </Skeleton>
                                </div>
                            </div>
                        </td>
                        <td class="">
                            <div class="d-flex justify-content-center">
                                <Skeleton class="" width="30%" height="1.3rem" borderRadius="3px"></Skeleton>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
