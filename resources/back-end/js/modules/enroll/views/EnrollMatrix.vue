<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Enrollment Similar Matrix</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div style="display: inline-block; float: left;" id="container"></div>
                            <div style="display: inline-block; float: left;" id="legend"></div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</template>
<script>
import Matrix from '*/components/matrix.js';
import * as d3 from 'd3';

export default {
    name: 'EnrollMatrix',
    mounted() {
        this.loadMatrix();
    },
    methods: {
        loadMatrix() {
            d3.csv('/recommend/similarE_matrix.csv', (error, data) => {
                console.log(data);
                var columns = [], rows = []
                data.forEach(row => {
                    columns.push(row.course);
                    delete row.course;
                    var row_round = Object.values(row).map((val) => {
                        return val.slice(0, 4);
                    });
                    console.log(row_round);
                    rows.push(row_round)
                });
                // console.log(columns, rows);

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
        }
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
