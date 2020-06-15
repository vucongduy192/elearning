<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Enrollment Similar Item</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select v-model="current_course" class="form-control">
                                    <option value="" selected>Select course</option>
                                    <option
                                        v-for="course in this.courses"
                                        v-bind:value="course"
                                        v-bind:key="course"
                                        >{{ course }}</option
                                    >
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary" @click="buildTable()">
                                Top similar
                            </button>
                        </div>
                    </div>
                    <div class="row" v-if="this.current_row">
                        <div class="col-sm-6">
                            <table class="table no-padding">
                                <thead>
                                    <th>Course</th>
                                    <th>Score</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(c, key)  in this.current_row.slice(0, 6)" :key=key>
                                        <td v-if="c != null">{{ c[0] }}</td>
                                        <td v-if="c != null">{{ c[1] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Config combine coefficient</h3>
                </div>
                <div class="box-body">
                    <form @submit.prevent="saveConfig">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input
                                        v-model="config.c"
                                        type="text"
                                        name="c"
                                        class="form-control"
                                        placeholder="Enter float number [0, 1]"
                                    />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    Apply
                                </button>
                            </div>
                        </div>
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
        await this.$store.dispatch('actionFetchConfig', { vue: this });
        this.config = this.$store.state.storeConfig.config;
        d3.csv('/recommend/similar_matrix.csv', (error, data) => {
            this.data_csv = data;
            this.courses = data.map((row) => row.course).sort();
        });
    },
    data() {
        return {
            config: {},
            courses: {},
            current_course: '',
            current_row: null,
            data_csv: {},
        };
    },
    methods: {
        sortProperty(obj) {
            var sortable = [];
            for (var c in obj) {
                sortable.push([c, obj[c]]);
            }

            sortable.sort(function(a, b) {
                return b[1] - a[1];
            });
            delete sortable[0];
            return sortable;
        },
        buildTable() {
            this.current_row = this.data_csv.filter((row) => {
                return row.course === this.current_course;
            });
            delete this.current_row[0].course;
            this.current_row = this.sortProperty(this.current_row[0]);
        },
        async saveConfig() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await axios.post('/configs/update', { c: this.config.c });
                this.$store.dispatch('pushSuccessNotify', {
                    msg: this.$i18n.t('textUpdateConfigSuccess'),
                });
                this.loadMatrix();
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminMainLoading', { show: false });
        },
        loadMatrix() {
            d3.csv('/recommend/similar_matrix.csv', (error, data) => {
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
    border: 1px solid #ccc;
}

table {
    border-collapse: collapse;
}

#dataView {
    margin-top: 50px;
}
</style>
