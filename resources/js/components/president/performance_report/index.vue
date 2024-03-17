<template>
    <div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="">Chart Performance 5 year ago</h6>
                    </div>
                    <div class="card-body">
                        <canvas ref="donutChart" width="300" height="300" class="mb-2"></canvas>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
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
                        <h6 class="">รายการประวัติผลงานอาจารย์</h6>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';
import axios from "axios";
export default {
    data() {
        return {
            performance_counts: [],
            date: [],
            chartData: {
                labels: [],
                datasets: [{
                    label: 'Count',
                    data: [],
                    backgroundColor: ['#D04848', '#F3B95F', '#FDE767', '#1B3C73', '#8CC0DE']
                }]
            },
            user: [],
            User_pId: ''
        }
    },
    mounted() {
        const userId = document.getElementById('app').getAttribute('data-user-id');
        console.log(userId);
        console.log(this.user.p_id);
        this.get_UserProgram(userId);

    },
    methods: {

        get_UserProgram: async function (userId) {
            try {
                let response = await axios.get(`/api/president_get_user_data/${userId}`);
                this.user = response.data.user;
                this.User_pId = response.data.user.p_id;
                console.log(this.User_pId);
                this.performance_count_check(this.User_pId)
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
                });
                console.log(this.date);
                this.renderBarChart();
                this.renderDonutChart();
            } catch (error) {
                console.error("Error fetching user:", error);
            }
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
    }
}
</script>

<style scoped>
/* Add your styles here */
</style>
