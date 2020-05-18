<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Course List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <router-link :to="{ name: 'main.course.add' }" class="btn btn-success">
                                Add new course
                            </router-link>
                        </div>

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

                        <div class="col-sm-3 pull-right">
                            <div class="form-group">
                                <select
                                    v-model="courses_category_id"
                                    class="form-control"
                                    @change="getResults()"
                                >
                                    <option v-bind:value="-1" v-bind:key="-1"> All category</option>
                                    <option
                                        v-for="category in categories"
                                        v-bind:value="category.id"
                                        v-bind:key="category.id"
                                        >{{ category.name }}</option
                                    >
                                </select>
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
                                        <th id="name" @click="clickSort('name')">
                                            Name <i class="sort"></i>
                                        </th>
                                        <th id="enrolls" @click="clickSort('enrolls')">
                                            Enrolls <i class="sort"></i>
                                        </th>
                                        <th id="level" @click="clickSort('level')">
                                            Level <i class="sort"></i>
                                        </th>
                                        <th id="teacher" @click="clickSort('teacher')">
                                            Teacher <i class="sort"></i>
                                        </th>
                                        <th>Category</th>
                                        <th>Thumbnail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="course in listFetch.data" :key="course.id">
                                        <td>{{ course.id }}</td>
                                        <td>{{ course.name }}</td>
                                        <td>{{ course.enrolls }}</td>
                                        <td>{{ levels[course.level] }}</td>
                                        <td>{{ course.teacher }}</td>
                                        <td>{{ course.courses_category }}</td>
                                        <td>
                                            <img :src="course.thumbnail" alt="" />
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning btn-flat"
                                                @click="clickEdit(course)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger btn-flat"
                                                data-toggle="modal"
                                                data-target="#delModal"
                                                @click="clickDelete(course)"
                                            >
                                                Delete
                                            </button>
                                        </td>
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
        </div>
    </div>
</template>

<script>
import Pagination from 'laravel-vue-pagination';
import axios from 'axios';

export default {
    name: 'Course',
    components: {
        Pagination,
    },
    mounted() {
        this.$store.dispatch('actionFetchCategory', { vue: this, params: {} });
        this.getResults();
    },
    data() {
        return {
            sortColumn: 'id',
            sortType: 'asc',
            name: '',
            courses_category_id: -1,
            levels: ['Easy', 'Medium', 'Hard'],
            delCourse: null,
        };
    },
    computed: {
        listFetch() {
            return this.$store.state.storeCourse.listFetch;
        },
        categories() {
            return this.$store.state.storeCategory.listFetch.data;
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
            this.$store.dispatch('actionFetchCourse', {
                vue: this,
                params: {
                    page: page,
                    name: this.name,
                    courses_category_id: this.courses_category_id,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
        },
        clickEdit(course) {
            this.$router.push({ name: 'main.course.edit', params: { id: course.id } });
        },
        clickDelete(course) {
            this.$store.dispatch('passEntityDeleteModal', {
                entity: course,
                entityAction: 'actionCourseDelete',
                entityNotify: this.$i18n.t('textDeleteCourseSuccess'),
            });
        },
    },
};
</script>
<style scoped>
.matrix,
.csv {
    margin-right: 10px;
}
</style>
