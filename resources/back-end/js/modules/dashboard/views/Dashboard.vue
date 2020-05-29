<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Top courses</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="planet-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Best professors</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div v-for="professor in best_professors" :key="professor.id">
                                <div class="col-sm-3">
                                    <div class="circle-img">
                                        <img src="/images/user_placeholder.png" class="img-responsive" alt="Cinque Terre">
                                        <a href="/professors/2" target="_blank">{{ professor.name }}</a>
                                        <p>{{ professor.expert }}</p>
                                        <p>{{ professor.workplace }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Chart from 'chart.js';

export default {
    name: 'Dashboard',
    async mounted() {
        await this.$store.dispatch('actionFetchChart', { vue: this });
        this.drawChart();
    },
    computed: {
        top_courses() {
            return this.$store.state.storeDashboard.top_courses;
        },
        best_professors() {
            return this.$store.state.storeDashboard.best_professors;
        },
    },
    methods: {
        drawChart() {
            const ctx = $('#planet-chart');
            const myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: this.top_courses.map(c => c.name),
                    datasets: [
                        {
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            hoverBackgroundColor: 'rgba(75, 192, 192, 0.4)',
                            hoverBorderColor: 'rgba(75, 192, 192, 1)',
                            data: this.top_courses.map(c => c.enrolls),
                        },
                    ],
                },
                options: {
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [
                            {
                                ticks: {
                                    beginAtZero: true,
                                },
                            },
                        ],
                    },
                },
            });
        },
    },
};
</script>

<style scoped>
.circle-img{
    text-align: center;
}
</style>