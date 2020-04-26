<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Config combine coefficient</h3>
                </div>
                <div class="box-body">
                    <form @submit.prevent="saveConfig" class="form-inline">
                        <div class="form-group">
                            <label for="" style="margin-top: 5px;">Combine c: </label>
                            <input
                                v-model="config.c"
                                type="text"
                                name="c"
                                class="form-control pull-right"
                                placeholder="Enter float number [0, 1]"
                            />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Apply
                        </button>
                    </form>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Enrollment Similar Matrix</h3>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div style="display: inline-block; float: left;" id="container"></div>
                        <div style="display: inline-block; float: left;" id="legend"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Matrix from '*/components/matrix.js';
import * as d3 from 'd3';
import axios from 'axios';

export default {
    name: 'Config',
    async mounted() {
        // this.loadMatrix();
        await this.$store.dispatch('actionFetchConfig', { vue: this });
        this.config = this.$store.state.storeConfig.config;
    },
    data() {
        return {
            config: {},
        };
    },
    methods: {
        async saveConfig() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await axios.post('/configs/update', { c: this.config.c });
                this.loadMatrix();
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminMainLoading', { show: false });
        },
        loadMatrix() {
            d3.csv('/recommend/similar_matrix.csv', (error, data) => {
                console.log(data);
                var columns = [],
                    rows = [];
                data.forEach((row) => {
                    columns.push(row.course);
                    delete row.course;
                    var row_round = Object.values(row).map((val) => {
                        return val.slice(0, 4);
                    });

                    rows.push(row_round);
                });
                console.log(columns, rows);

                // Clear half of matrix (symmetric matrix)
                var num = columns.length;
                var i, j;
                for (i = 0; i < num; i++) {
                    for (j = num - 1; j > i; j--) rows[i][j] = '';
                }
                Matrix({
                    container: '#container',
                    data: rows,
                    labels: columns,
                    start_color: '#ffffff',
                    end_color: '#0062ff',
                });
            });
        },
    },
};
</script>
<style scoped>
#container {
    margin-left: 5%;
}
.axis text {
    font: 10px sans-serif;
}

.axis line,
.axis path {
    fill: none;
    stroke: #000;
    shape-rendering: crispEdges;
}

td,
th,
tr {
    padding: 4px;
    border: 1px solid black;
}

table {
    border-collapse: collapse;
}

#dataView {
    margin-top: 50px;
}
</style>
