<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Teacher List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-3 pull-right">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Search"
                                    v-model="name"
                                    v-on:keyup.enter="getResults()"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover no-padding">
                                <thead>
                                    <tr>
                                        <th id="id" @click="clickSort('id')">
                                            ID <i class="sort fa fa-fw fa-sort-asc pull-right"></i>
                                        </th>
                                        <th id="name" @click="clickSort('name')">Name <i class="sort"></i></th>
                                        <th id="email" @click="clickSort('email')">Email <i class="sort"></i></th>
                                        <th id="expert" @click="clickSort('expert')">Expert <i class="sort"></i></th>
                                        <th>Avatar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="teacher in listFetch.data" :key="teacher.id">
                                        <td>{{ teacher.id }}</td>
                                        <td>{{ teacher.name }}</td>
                                        <td>{{ teacher.email }}</td>
                                        <td>{{ teacher.expert }}</td>
                                        <td>
                                            <img :src="teacher.avatar" alt="" />
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-info btn-flat"
                                                @click="clickView(teacher)"
                                            >
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :data="listFetch" :limit="3" @pagination-change-page="getResults">
                                <span slot="prev-nav">Previous</span>
                                <span slot="next-nav">Next</span>
                            </pagination>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from 'laravel-vue-pagination';
import axios from 'axios';

export default {
    name: 'Teacher',
    components: {
        Pagination,
    },
    mounted() {
        this.getResults();
    },
    data() {
        return {
            sortColumn: 'id',
            sortType: 'asc',
            name: '',
        };
    },
    computed: {
        listFetch() {
            return this.$store.state.storeUser.listFetch;
        },
    },
    methods: {
        clickSort(column) {
            this.sortType = this.sortType === 'desc' ? 'asc' : 'desc';
            this.sortColumn = column;

            $('.sort').replaceWith('<i class="sort"></i>');
            $(`#${this.sortColumn} .sort`).replaceWith(
                `<i class="sort fa fa-fw fa-sort-${this.sortType} pull-right"></i>`
            );

            this.getResults();
        },
        getResults(page = 1) {
            this.$store.dispatch('actionFetchTeacher', { 
                vue: this, 
                params: {
                    page: page,
                    name: this.name,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
        },
        clickView(teacher) {

        }
    },
};
</script>
<style scoped>
    .matrix, .csv {
        margin-right: 10px;
    }
</style>