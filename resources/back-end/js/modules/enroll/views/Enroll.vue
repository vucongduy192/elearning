<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Enroll List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-info btn-flat csv" @click="clickCSV()">
                                Apply enrollment data
                            </button>
                            <router-link
                                :to="{ name: 'main.enroll.matrix' }"
                                class="btn btn-primary matrix"
                            >
                                See Matrix
                            </router-link>
                        </div>
                        <div class="col-sm-3 pull-right">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Course"
                                    v-model="course_name"
                                    v-on:keyup.enter="getResults()"
                                />
                            </div>
                        </div>
                        <div class="col-sm-3 pull-right">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Email"
                                    v-model="email"
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
                                            ID <i class="sort fa fa-fw fa-sort-desc pull-right"></i>
                                        </th>
                                        <th id="username" @click="clickSort('username')">
                                            Student <i class="sort"></i>
                                        </th>
                                        <th id="email" @click="clickSort('email')">
                                            Email <i class="sort"></i>
                                        </th>
                                        <th id="course_name" @click="clickSort('course_name')">
                                            Course <i class="sort"></i>
                                        </th>
                                        <th>Category</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="enroll in listFetch.data" :key="enroll.id">
                                        <td>{{ enroll.id }}</td>
                                        <td>{{ enroll.username }}</td>
                                        <td>{{ enroll.email }}</td>
                                        <td>{{ enroll.course_name }}</td>
                                        <td>{{ enroll.courses_category }}</td>
                                        <!-- <td>
                                            <button
                                                class="btn btn-sm btn-info btn-flat"
                                                @click="clickEdit(enroll)"
                                            >
                                                View
                                            </button>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                            <pagination
                                :data="listFetch"
                                :limit="3"
                                @pagination-change-page="getResults"
                            >
                                <span slot="prev-nav">Previous</span>
                                <span slot="next-nav">Next</span>
                            </pagination>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Recommend</h3>
                </div>
                <div class="box-body">
                    <form @submit.prevent="recommend">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input
                                        v-model="r_email"
                                        type="text"
                                        name="c"
                                        class="form-control"
                                        placeholder="Enter email"
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

                    <div class="row" v-if="this.recommends">
                        <div class="col-sm-8">
                            <table class="table no-padding">
                                <thead>
                                    <th>Recommend courses</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(c, key) in this.recommends" :key="key">
                                        <td>{{ c.name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from 'laravel-vue-pagination';
import axios from 'axios';

export default {
    name: 'Enroll',
    components: {
        Pagination,
    },
    mounted() {
        this.getResults();
    },
    data() {
        return {
            sortColumn: 'id',
            sortType: 'desc',
            course_name: '',
            email: '',
            r_email: '',
        };
    },
    computed: {
        listFetch() {
            return this.$store.state.storeEnroll.listFetch;
        },
        recommends() {
            return this.$store.state.storeEnroll.recommends;
        },
    },
    methods: {
        recommend() {
            this.$store.dispatch('actionFetchRecommend', {
                vue: this,
                params: {
                    email: this.r_email,
                },
            });
        },
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
            this.$store.dispatch('actionFetchEnroll', {
                vue: this,
                params: {
                    page: page,
                    course_name: this.course_name,
                    email: this.email,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
        },
        clickEdit(enroll) {
            this.$router.push({ name: 'main.enroll.edit', params: { id: enroll.id } });
        },
        async clickCSV() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await axios.post('/enrolls/csv');
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminMainLoading', { show: false });
        },
    },
};
</script>