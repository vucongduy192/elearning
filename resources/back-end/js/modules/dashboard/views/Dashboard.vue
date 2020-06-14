<template>
    <div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Top courses enrolled</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="top-chart"></canvas>
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
                                        <img
                                            class="img-responsive"
                                            alt="Cinque Terre"
                                            :src="
                                                professor.avatar
                                                    ? professor.avatar
                                                    : '/images/user_placeholder.png'
                                            "
                                        />
                                        <a href="/professors/2" target="_blank">{{
                                            professor.name
                                        }}</a>
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
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Best courses reviewed</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="best-chart"></canvas>
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
        this.drawChart(
            '#top-chart',
            this.top_courses.map((c) => c.name),
            this.top_courses.map((c) => c.enrolls)
        );

        this.drawChart(
            '#best-chart',
            this.best_courses.map((c) => c.name),
            this.best_courses.map((c) => c.rating)
        );
    },
    computed: {
        top_courses() {
            return this.$store.state.storeDashboard.top_courses;
        },
        best_professors() {
            return this.$store.state.storeDashboard.best_professors;
        },
        best_courses() {
            return this.$store.state.storeDashboard.best_courses;
        },
    },
    methods: {
        drawChart(id, labels, data) {
            const ctx = $(id);
            const myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            hoverBackgroundColor: 'rgba(75, 192, 192, 0.4)',
                            hoverBorderColor: 'rgba(75, 192, 192, 1)',
                            data: data,
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
.circle-img {
    text-align: center;
}
</style>
