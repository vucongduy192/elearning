<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Logs file</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Select file</label>
                                <select
                                    v-model="current_file"
                                    class="form-control"
                                    @change="loadCSV"
                                >
                                    <option
                                        v-for="file in files"
                                        v-bind:value="file.file_name"
                                        v-bind:key="file.file_name"
                                        >{{ file.name }}</option
                                    >
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div
                                id="log_wrapper"
                                style="
                                    postion: relative;
                                    height: 300px;
                                    width: 100%;
                                    overflow-y: auto;
                                "
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Enroll',
    mounted() {
        this.loadCSV();
    },
    data() {
        return {
            current_file: 'category_matrix.csv',
            files: [
                { name: 'Category Rule Matrix', file_name: 'category_matrix.csv' },
                { name: 'Enrollment Matrix', file_name: 'enroll_matrix.csv' },
                { name: 'Category Rule Similar', file_name: 'similarC_matrix.csv' },
                { name: 'Enrollment Similar', file_name: 'similarE_matrix.csv' },
                { name: 'Course similar', file_name: 'similar_matrix.csv' },
            ],
        };
    },
    methods: {
        loadCSV() {
            $.ajax({
                url: `/recommend/${this.current_file}`,
                dataType: 'text',
                success: function (data) {
                    var employee_data = data.split(/\r?\n|\r/);
                    var table_data =
                        '<table id="log_table" class="table table-bordered table-striped"';
                    for (var count = 0; count < employee_data.length; count++) {
                        var cell_data = employee_data[count].split(',');
                        table_data += '<tr>';
                        for (var cell_count = 0; cell_count < cell_data.length; cell_count++) {
                            if (count === 0) {
                                table_data += '<th>' + cell_data[cell_count] + '</th>';
                            } else {
                                table_data += '<td>' + cell_data[cell_count] + '</td>';
                            }
                        }
                        table_data += '</tr>';
                    }
                    table_data += '</table>';
                    $('#log_wrapper').html(table_data);
                },
            });
        },
    },
};
</script>
