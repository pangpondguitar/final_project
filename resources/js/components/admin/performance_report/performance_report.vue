<template>
    <div>
        <div class="row">
            <h4 class="mb-0 fw-normal">ตารางแสดงเปรียบเทียบการจัดทำผลงาน 5 ปีย้อนหลัง</h4>
            <h6 for="" class="text-sm fw-normal mb-3 text-muted">ตารางแสดงเปรียบเทียบผลงานทางวิชาการของอาจารย์</h6>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="">Chart Performance 5 year ago</h6>
                    </div>
                    <div class="card-body">
                        <canvas ref="donutChart" width="300" height="300" class="mb-2"></canvas>
                    </div>
                </div>

            </div>
            <div class="col-lg-7">
                <div class="card ">
                    <div class="card-header pb-0">
                        <h6 class="">Chart Performance 5 year ago</h6>
                    </div>
                    <div class="card-body">
                        <canvas ref="BarChart" width="300" height="300" class="mb-2"></canvas>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card h-100 ">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">รายการประวัติผลงานอาจารย์</h6>
                    </div>
                    <div class="table table-responsive mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label for="">อาจารย์ที่มีผลงานในปี</label>
                                    <select name="" id="" class="form-control" v-model="input">
                                        <option value="" class="" disabled>กรุณาเลือกปี</option>
                                        <option v-for="item in year" :key="item.id" :value="item">{{ item }}</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">ค้นหาชื่ออาจารย์</label>
                                    <input type="text" class="form-control" placeholder="Search..." v-model="input">
                                </div>
                            </div>
                            <div class="item error" v-if="input && !filteredList().length">
                                <p>ไม่พบข้อมูล!</p>
                            </div>
                        </div>

                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <td class="td-p">

                                        <label class="text-muted ms-3"> อาจารย์</label>
                                    </td>
                                    <td class="td-p3">

                                        <label class="text-muted">สถานะ</label>
                                    </td>
                                    <td class="td-p2">
                                        <label class="text-muted">อีเมลล์</label>
                                    </td>
                                    <td>
                                        <label class="text-muted">รายละเอียด</label>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in this.filteredList()" :key="item.id">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div >
                                                <div v-if="item.user_detail
                                            .user_d_pic != ''
                                        ">
                                                    <img :src="'/uploads/profile_pic/' +
                                        item.user_detail
                                            .user_d_pic
                                        " class="avatar avatar-sm me-2 ms-2" />
                                                </div>
                                                <div v-else>
                                                    <img src="../../../../../public/assets/img/user.png"
                                                        class="avatar avatar-sm me-2 ms-2" />
                                                </div>
                                            </div>
                                            <div class="ms-1">
                                                <h6 class="text-dark mb-0 text-sm  "> {{
                                        item.user_detail.user_d_name }}</h6>
                                                <span for="" class="text-sm fw-normal text-muted py-0">{{
                                        item.user_detail.user_d_name2
                                    }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <label for="" class="text-dark mb-0"> positive</label>
                                    </td>
                                    <td class="align-middle">
                                        <p for="" class=" text-muted fw-normal text-sm mb-0">{{
                                            item.user_detail.user_d_email
                                        }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-sm bg-gradient-primary fw-normal mb-0"
                                            @click="goToPerformanceReportDetail( item.id)">ดูรายละเอียด</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from "axios";
import { useRouter } from "vue-router";
import { ref } from "vue";
export default {
    setup() {
        const router = useRouter();

        const goToPerformanceReportDetail = (id) => {
            router.push(`/admin/performance_report/performance_report_detail/${id}`);
        };

        return {
            goToPerformanceReportDetail
        };

    },
    data() {
        return {
            performance_counts: [],
            date: [],
            chartData: {
                labels: [],
                datasets: [{
                    label: 'Count',
                    data: [],
                    backgroundColor: ['#E178C5', '#FFB38E', '#FDE767', '#1B3C73', '#40679E']
                }]
            },
            user: [],
            User_pId: '',
            teachers: [],
            input: '',
            year: [],
        }
    },

    mounted() {
        // const userId = document.getElementById('app').getAttribute('data-user-id');

        this.performance_count_check(this.id);
        this.get_Teacher(this.id);
    },
    methods: {
        get_Teacher: async function (id) {
            try {
                let response = await axios.get(`/api/performance_teacher/${id}`);
                this.teachers = response.data.teacher;
                console.log(this.teachers);
            } catch (error) {
                console.error("Error fetching user:", error);
            }
        },
        get_UserProgram: async function (userId) {
            try {
                let response = await axios.get(`/api/president_get_user_data/${userId}`);
                this.user = response.data.user;
                this.User_pId = response.data.user.p_id;
                console.log(this.User_pId);
                this.performance_count_check(this.User_pId);
                this.get_Teacher(this.User_pId);
            } catch (error) {
                console.error("Error fetching user:", error);
            }
        },

        performance_count_check: async function (id) {
            try {

                let response = await axios.get(`/api/performance_count_check/${id}`);
                this.performance_counts = response.data.performance_counts;
                this.date = response.data.date;

                const data = response.data.date;
                data.forEach(item => {
                    this.chartData.labels.push(item.year);
                    this.chartData.datasets[0].data.push(item.count);
                    this.year.push(item.year);
                });
                console.log(this.date);
                this.renderBarChart();
                this.renderDonutChart();
            } catch (error) {
                console.error("Error fetching user:", error);
            }
        },
        filteredList() {
            console.log(this.input);
            return this.teachers.filter((item) =>
                item.performance.some((performance) => performance.pf_year === this.input) ||
                this.input === '' ||
                item.user_detail.user_d_name.toLowerCase().includes(this.input.toLowerCase())
            );
        },

        renderDonutChart() {
            const ctx = this.$refs.donutChart.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: this.chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        },
        renderBarChart() {
            const ctx = this.$refs.BarChart.getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: this.chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        },
        Report_detail(id) {
            router.push('/admin/performance_report/performance_detail/' + id);
        }

    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
}
</script>

<style scoped>
.img-icon-t-p {
    width: 45px;
}

.td-p {
    width: 34%;
}

.td-p3 {
    width: 20%;
}

.td-p2 {
    width: 28%;
}
</style>
