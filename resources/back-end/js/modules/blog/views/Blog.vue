<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Blog List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <router-link
                                :to="{ name: 'main.blog.add' }"
                                class="btn btn-success"
                            >
                                Add new post
                            </router-link>
                        </div>
                        <div class="col-sm-3 pull-right">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Search"
                                    v-model="title"
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
                                        <th id="title" @click="clickSort('title')">Title <i class="sort"></i></th>
                                        <th>Summary</th>
                                        <th>Thumbnail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="blog in listFetch.data" :key="blog.id">
                                        <td>{{ blog.id }}</td>
                                        <td>{{ blog.title }}</td>
                                        <td>{{ blog.summary }}</td>
                                        <td>
                                            <img :src="blog.thumbnail" alt="" />
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning btn-flat"
                                                @click="clickEdit(blog)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger btn-flat"
                                                @click="clickDelete(blog)"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :data="listFetch" @pagination-change-page="getResults">
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

export default {
    name: 'Blog',
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
            title: '',
        };
    },
    computed: {
        listFetch() {
            return this.$store.state.storeBlog.listFetch;
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
            this.$store.dispatch('actionFetchBlog', {
                vue: this,
                params: {
                    page: page,
                    name: this.name,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
        },

        clickEdit(blog) {
            this.$router.push({ name: 'main.blog.edit', params: { id: blog.id } });
        },

        async clickDelete(blog) {
            return (
                blog.id &&
                (await this.$swal({
                    title: this.$i18n.t('textConfirmDelete'),
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })) &&
                this.$store.dispatch('actionBlogDelete', { vue: this, id: blog.id })
            );
        },
    },
};
</script>
