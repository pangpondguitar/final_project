<script setup>
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

import Toast from 'primevue/toast';
import { useToast } from "primevue/usetoast";
import RadioButton from 'primevue/radiobutton';

const router = useRouter();
let programs = ref([]);
let selected_program = ref('');
let users = ref([]);
let input = ref("");
let selectedImage = ref('/assets/img/eskimo.png');
let imageUrl = ref('/assets/img/eskimo.png');
const user_type = ref('2');

const toast = useToast();

const showError = () => {
    toast.add({ severity: 'error', summary: 'Error Message', detail: 'ชื่อบัญชีผู้ใช้ซ้ำ กรุณาตรวจสอบอีกครั้ง', life: 3000 });
};
const showSuccess = () => {
    toast.add({ severity: 'success', summary: 'Success Add Teacher', detail: 'บันทึกข้อมูลผุ้ใช้สำเร็จ', life: 3000 });
};


const isLoadingData = ref(true);
const checked = ref(false);

const inputValue = ref("");
const isValid = ref(true);
let form = ref({
    username: "",
    password: "",
    email: "",
    name: "",
    name2: "",
    phone: "",
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
const select_program = async () => {
    const p_id = selected_program.value;
    console.log(p_id);
};
const AddUser = () => {
    const formData = new FormData();
    formData.append('file', selectedImage.value);
    formData.append("username", form.value.username);
    formData.append("email", form.value.email);
    formData.append("password", form.value.password);
    formData.append("user_type", user_type.value);

    formData.append("name", form.value.name);
    formData.append("name2", form.value.name2);
    formData.append("address", form.value.address);
    formData.append("phone", form.value.phone);
    formData.append("program", selected_program.value);

    axios
        .post(`/api/admin_add_users/`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then((response) => {
            if (response.data.success) { // ตรวจสอบค่า 'success' ในข้อมูลที่ส่งกลับมาจาก API
                showSuccess();
                form.value.username = '',
                    form.value.password = '',
                    selectedImage.value = '/assets/img/eskimo.png',
                    form.value.email = '',
                    user_type.value = '2',
                    form.value.name = '',
                    form.value.name2 = '',
                    form.value.address = '',
                    form.value.phone = '',
                    form.value.program = ''
            }

        })
        .catch((error) => {
            if (error.response.data.message_err) {
                showError();
            }
        });
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
const onFileChange = (event) => {
    selectedImage.value = event.target.files[0];
    previewImage();
}

const previewImage = () => {
    const reader = new FileReader();
    reader.readAsDataURL(selectedImage.value);
    reader.onload = (event) => {
        imageUrl.value = event.target.result;
    };
}
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

const User_home = (id) => {
    router.push("/admin/users");
};

onMounted(async () => {
    await getProgram();
});
</script>

<template>
    <div class="row">
        <Toast />

        <div class="col-lg-12 mt-lg-0 mt-4">
            <div class="card mt-4" id="basic-info">

                <div class="card-header  pb-3  border-bottom  ">
                    <h5 class="mb-0">ข้อมูลส่วนตัว</h5>
                    <small class="text-muted">เพิ่มผู้ใช้งาน กรอกรายละเอียด</small>
                </div>

                <div class="card-body pt-0">
                    <div>
                        <!-- Input file -->
                        <input type="file" @change="onFileChange" id="avatarInput" class="hidden mt-3">

                        <!-- Avatar preview -->
                        <label for="avatarInput" class="mt-3">
                            <img v-if="imageUrl" :src="imageUrl" alt="Avatar" class="avatar">
                            <div v-else class="avatar-placeholder">เลือกรูปภาพ</div>
                        </label>

                        <!-- Submit button -->
                    </div>

                    <form @submit.prevent="submitForm">
                        <div class="row">
                            <div class="col-lg-6 mt-3">
                                <label class="form-label text-sm mb-1">ชื่อ-นามสกุล</label>
                                <div class="input-group">
                                    <input id="firstName" name="name" class="form-control" type="text"
                                        placeholder="ป้อนชื่อ-นามสกุล" v-model="form.name" />
                                </div>
                                <p v-if="!isValid" class="text-sm fw-normal text-danger mb-0">
                                    กรุณาชื่อ - นามสกุล
                                </p>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <label class="form-label text-sm mb-1">ชื่อภาษาอังกฤษ</label>
                                <div class="input-group">
                                    <input id="lastName" name="name2" class="form-control" type="text"
                                        placeholder="ป้อนชื่อ-นามสกุล(ภาษาอังกฤษ)" v-model="form.name2" />
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

                                    <input id="confirmation" name="password" class="form-control" type="password"
                                        placeholder="ป้อนรหัสผ่าน" v-model="form.password" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-3">
                                <label class="form-label text-sm mb-1">Email</label>
                                <div class="input-group">
                                    <input id="location" name="email" class="form-control" type="email"
                                        placeholder="ป้อนอีเมล" v-model="form.email" />
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label class="form-label mb-1 text-sm">เบอร์โทรศัพท์</label>
                                <div class="input-group">
                                    <input id="phone" name="phone" class="form-control" type="number"
                                        placeholder="ป้อนเบอร์โทรศัพท์" v-model="form.phone" />
                                </div>
                            </div>
                            <div class="col-lg-4 mt-3">
                                <label class="form-label mb-1 text-sm">เลือกสาขา</label>
                                <select name="program" class="form-control" v-model="selected_program">
                                    <option value="" disabled>เลือกสาขาวิชา</option>
                                    <option v-for="item in programs" :key="item.id" :value="item.p_id">
                                        {{ item.p_name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label mt-4 text-sm">ที่อยู่</label>
                                <textarea name="address" class="form-control" cols="30" rows="3"
                                    v-model="form.address"></textarea>
                            </div>

                            <div class="d-flex flex-row gap-3 mt-3">
                                <div>
                                    <label for="" class="text-sm mt-2 me-3">กำหนดสิทธิ์</label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <RadioButton v-model="user_type" name="teacher" value="2"
                                        :checked="user_type === '2'" />
                                    <p for="ingredient1" class="me-4 mb-0 text-sm ms-2 ">อาจารย์</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <RadioButton v-model="user_type" name="manager" value="4" />
                                    <p for="4" class="me-4 mb-0 text-sm ms-2 ">ผู้บริหาร</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <RadioButton v-model="user_type" name="president" value="3" />
                                    <p for="ingredient2" class="me-4 mb-0 text-sm ms-2 py-2">ประธานหลักสูตร</p>
                                </div>

                            </div>

                        </div>
                        <div class="row d-flex text-end mt-3">
                            <div class="col-lg-12">
                                <a class="btn btn-white border text-dark shadow-none border-1 mb-0 px-5 text-sm"
                                    @click="User_home()">กลับ</a>
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
<style scoped>
/* CSS styles */
.hidden {
    display: none;
}

.avatar {
    width: 120px;
    /* ปรับขนาดตามที่ต้องการ */
    height: 120px;
    /* ปรับขนาดตามที่ต้องการ */
    border-radius: 50%;
    cursor: pointer;
}

.avatar-placeholder {
    width: 140px;
    /* ปรับขนาดตามที่ต้องการ */
    height: 140px;
    /* ปรับขนาดตามที่ต้องการ */
    border-radius: 50%;
    border: 2px dashed #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
</style>
