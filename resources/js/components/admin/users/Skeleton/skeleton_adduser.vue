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
            <Skeleton class="mb-2" width="15%" height="2rem" borderRadius="8px"></Skeleton>
        </div>
        <div class="card-body pt-0">
            <div class="row">
                <div class="col-lg-6">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
                <div class="col-lg-6">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-6">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
                <div class="col-lg-6">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
                <div class="col-4">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
                <div class="col-4">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="2rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <Skeleton class="mb-2" width="20%" height="0.8rem" borderRadius="8px"></Skeleton>
                    <div class="input-group">
                        <Skeleton class="mb-2" width="100%" height="9rem" borderRadius="8px"></Skeleton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
