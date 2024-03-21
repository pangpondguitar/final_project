<script setup>
import { ref } from "vue";

const pic = ref("resources/js/components/users/assets/logo-empty.png");
</script>
<template>
    <div class="row">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card p-3">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-2">
                            <div
                                class="bg-gradient-dark border-radius-lg h-100"
                            >
                                <div
                                    class="position-relative d-flex align-items-center justify-content-center h-100"
                                >
                                    <img
                                        class="w-75 position-relative z-index-2"
                                        src="/resources/js/components/users/assets/logo-empty.png"
                                        alt="rocket"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 ms-2">
                            <div class="row">
                                <h4
                                    class="text-success text-gradient fs-head2 mt-1 fw-normal"
                                >
                                    ยินดีต้อนรับเข้าสู่ระบบ
                                </h4>
                                <hr class="my-0 py-0 p-0 mb-2" />
                                <h3
                                    class="text-dark mb-1 mt-1 fs-head fw-normal"
                                >
                                    ระบบจัดการหลักสูตร
                                    คณะวิทยาศาสตร์และเทคโนโลยี
                                </h3>
                                <h4 class="fw-normal text-muted fs-title mb-3">
                                    มหาวิทยาลัยราชภัฏสุราษฎร์ธานี
                                </h4>
                                <h6 class="fw-normal text-muted text-secondary">
                                    Suratthani Rajabhat University
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-lg-7 mb-lg-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex flex-column h-100">
                                        <p class="mb-1 pt-2 text-bold">
                                            ยินดีต้อนรับเข้าสู่ระบบ
                                        </p>
                                        <h5 class="font-weight-bolder">
                                            President Dashboard
                                        </h5>
                                        <p class="mb-2">
                                            ระบบจัดการหลักสูตร
                                            คณะวิทยาศาสตร์และเทคโนโลยี
                                            มหาวิทยาลัยราชภัฏสุราษฎร์ธานี
                                        </p>
                                        <img
                                            src="https://scontent.fbkk12-4.fna.fbcdn.net/v/t1.15752-9/430992127_966174581523105_3099606043385735342_n.png?_nc_cat=107&ccb=1-7&_nc_sid=5f2048&_nc_eui2=AeEMmj-TfOvaluPKT--3giG_U35YenKqxu5Tflh6cqrG7hO_gu_hUEl2gA8l79WvaJpAobGJfBdVSYl7od-DZlP2&_nc_ohc=i9iqCj5pm9IAX_Nkqse&_nc_ht=scontent.fbkk12-4.fna&oh=03_AdSFPjpoSBTFlnEwUJ1H9MLJNg1RCK4gNZHKX377Wh1tpA&oe=6623D7EA"
                                            alt=""
                                            style="width: 250px"
                                        />
                                    </div>
                                </div>
                                <div
                                    class="col-lg-5 ms-auto text-center mt-5 mt-lg-0"
                                >
                                    <div
                                        class="bg-gradient-success border-radius-lg h-100"
                                    >
                                        <div
                                            class="position-relative d-flex align-items-center justify-content-center h-100 p-5"
                                        >
                                            <div clas>
                                                <h2 class="text-white">
                                                    President
                                                </h2>
                                                <h6
                                                    class="text-white fw-normal"
                                                >
                                                    Faculty of Science and
                                                    Technology
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card h-100 p-3">
                        <div
                            class="overflow-hidden position-relative border-radius-lg bg-cover h-100"
                            style="
                                background-image: url('../assets/img/ivancik.jpg');
                            "
                        >
                            <span class="mask bg-gradient-dark"></span>
                            <div
                                class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3"
                            >
                                <h6 class="text-white mb-4 pt-2">
                                    มหาวิทยาลัยราชภัฏสุราษฎร์ธานี
                                </h6>
                                <p class="text-white">
                                    272 ถ. สุราษฎร์-นาสาร ต.ขุนทะเล อ.เมือง
                                    จ.สุราษฎร์ธานี 84100 โทรศัพท์ : 077 913333
                                    โทรสาร : 077 913348

                                    <br />
                                    อีเมล์ : saraban@sru.ac.th
                                </p>
                                <a
                                    class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto"
                                    href="javascript:;"
                                >
                                    Read More
                                    <i
                                        class="fas fa-arrow-right text-sm ms-1"
                                        aria-hidden="true"
                                    ></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.sru-logo {
    width: 190px;
}

.fs-head {
    font-size: 22px !important;
}

.fs-head2 {
    font-size: 27px !important;
}

.fs-title {
    font-size: 16px !important;
}
</style>
