<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Category List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <router-link
                                :to="{ name: 'main.category.add' }"
                                class="btn btn-success"
                            >
                                Add new category
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
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover no-padding">
                                <thead>
                                    <tr>
                                        <th id="id" @click="clickSort('id')">
                                            ID <i class="sort fa fa-fw fa-sort-desc pull-right"></i>
                                        </th>
                                        <th id="name" @click="clickSort('name')">Name <i class="sort"></i></th>
                                        <th>Overview</th>
                                        <th>Thumbnail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in listFetch.data" :key="category.id">
                                        <td>{{ category.id }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.overview }}</td>
                                        <td>
                                            <img :src="category.thumbnail" alt="" />
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning btn-flat"
                                                @click="clickEdit(category)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger btn-flat"
                                                @click="clickDelete(category)"
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
    name: 'Category',
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
            name: '',
        };
    },
    computed: {
        listFetch() {
            return this.$store.state.storeCategory.listFetch;
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
            this.$store.dispatch('actionFetchCategory', {
                vue: this,
                params: {
                    page: page,
                    name: this.name,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
        },

        clickEdit(category) {
            this.$router.push({ name: 'main.category.edit', params: { id: category.id } });
        },

        async clickDelete(category) {
            return (
                category.id &&
                (await this.$swal({
                    title: this.$i18n.t('textConfirmDelete'),
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })) &&
                this.$store.dispatch('actionCategoryDelete', { vue: this, id: category.id })
            );
        },
    },
};
</script>
