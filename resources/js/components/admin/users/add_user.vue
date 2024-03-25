<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

import Toast from "primevue/toast";

const router = useRouter();
let programs = ref([]);
let users = ref([]);
let input = ref("");
const isLoadingData = ref(true);

const inputValue = ref("");
const isValid = ref(true);
let form = ref({
    username: "",
    password: "",
    email: "",
    name: "",
    name2: "",
    address: "",
    programs: "",
});
const submitForm = () => {
    if (form.value.username.trim() === "") {
        isValid.value = false;
    } else {
        isValid.value = true;
        AddUser();
    }
};

const AddUser = () => {
    const formData = new FormData();
    formData.append("username", form.value.username);
    formData.append("password", form.value.password);
    formData.append("email", form.value.email);
    axios
        .post(`/api/admin_add_users/`, formData)
        .then((response) => {
            (form.value.username = ""), (form.value.password = "");
        })
        .catch((error) => {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
                footer: '<a href="#">Why do I have this issue?</a>',
            });
        });

    // toast.fire({
    //     icon: "success",
    //     title: "Subject add successfully",
    // });
};
const getProgram = async () => {
    try {
        let response = await axios.get("/api/admin_get_all_programs");
        programs.value = response.data.programs;
        console.log("programs", programs.value);
    } catch (error) {
        console.error("Error fetching programs:", error);
    }
};

const getUserAll = async () => {
    setTimeout(async () => {
        try {
            let response = await axios.get("/api/admin_get_all_users");
            users.value = response.data.users;
            console.log("users", users.value);
            isLoadingData.value = false;
        } catch (error) {
            console.error("Error fetching users:", error);
        }
    });
};

const courses_all = (id) => {
    router.push("/admin/courses/courses_all/" + id);
};

onMounted(async () => { });
</script>

<template>
    <div class="row">
        <div class="col-lg-12 mt-lg-0 mt-4">
            <div class="card mt-4" id="basic-info">
                <div class="card-header p-3">
                    <h5 class="mb-0">ข้อมูลส่วนตัว</h5>
                </div>

                <div class="card-body pt-0 p-3">
                    <form @submit.prevent="submitForm">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label class="form-label text-sm mb-1">ชื่อ-นามสกุล</label>
                                <div class="input-group">
                                    <input id="firstName" name="name" class="form-control" type="text"
                                        placeholder="ป้อนชื่อ-นามสกุล" />
                                </div>
                                <p v-if="!isValid" class="text-sm fw-normal text-danger mb-0">
                                    กรุณาชื่อ - นามสกุล
                                </p>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label class="form-label text-sm mb-1">ชื่อภาษาอังกฤษ</label>
                                <div class="input-group">
                                    <input id="lastName" name="name2" class="form-control" type="text"
                                        placeholder="ป้อนชื่อ-นามสกุล(ภาษาอังกฤษ)" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label class="form-label text-sm mb-1">ชื่อบัญชีผู้ใช้ (username)</label>
                                <div class="input-group">
                                    <input id="email" name="username" class="form-control" type="text"
                                        placeholder="ป้อนชื่อบัญชีผู้ใช้" v-model="form.username" />
                                </div>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label class="form-label mb-1 text-sm">รหัสผ่าน(password)</label>
                                <div class="input-group">
                                    <input id="confirmation" name="password" class="form-control" type="text"
                                        placeholder="ป้อนรหัสผ่าน" v-model="form.password" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 mt-3">
                                <label class="form-label text-sm mb-1">Email</label>
                                <div class="input-group">
                                    <input id="location" name="email" class="form-control" type="email"
                                        placeholder="ป้อนอีเมล" />
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <label class="form-label mb-1 text-sm">เบอร์โทรศัพท์</label>
                                <div class="input-group">
                                    <input id="phone" name="phone" class="form-control" type="number"
                                        placeholder="ป้อนเบอร์โทรศัพท์" />
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <label class="form-label mb-1 text-sm">เลือกสาขา</label>
                                <select name="program" id="" class="form-control"></select>
                            </div>
                            <div class="col-12">
                                <label class="form-label mt-4 text-sm">ที่อยู่</label>
                                <textarea name="address" class="form-control" id="" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row d-flex text-end mt-3">
                            <div class="col-lg-12">
                                <a
                                    class="btn btn-white border text-dark shadow-none border-1 mb-0 px-5 text-sm">กลับ</a>
                                <button class="btn bg-gradient-dark ms-2 mb-0 px-5 text-sm fw-normal" type="submit"
                                    name="button">
                                    บันทึกข้อมูล
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
