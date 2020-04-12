<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Rule Matrix</h3>
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
import Matrix from './matrix.js';
import * as d3 from 'd3';

export default {
    name: 'RuleMatrix',
    async mounted() {
        await this.$store.dispatch('actionFetchCategory', { vue: this, params: {} });
        d3.csv('/recommend/category_matrix.csv', (error, data) => {
            var columns = [], rows = []
            data.forEach(row => {
                columns.push(row.category_id);
                delete row.category_id;
                rows.push(Object.values(row));
            });
            
            var num = columns.length;
            var i, j;
            for (i = 0; i < num; i++) {
                for (j = num - 1; j > i; j--) rows[i][j] = '';
            }

            var labels = [];
            columns.forEach(id => {
                var category = this.categories.filter((c) => {
                    return c.id.toString() === id;
                });
                labels.push(category[0].name);
            });

            Matrix({
                container: '#container',
                data: rows,
                labels: labels,
                start_color: '#ffffff',
                end_color: '#0062ff',
            });

        });
    },
    computed: {
        categories() {
            return this.$store.state.storeCategory.listFetch.data;
        },
    },
    methods: {},
};
</script>
<style scoped>
#container {
    margin-left: 25%;
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
