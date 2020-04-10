<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Category List</h3>
                    <router-link
                        :to="{ name: 'main.category.add' }"
                        class="btn btn-success pull-right"
                    >
                        Add new category
                    </router-link>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-hover no-padding">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
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
    computed: {
        listFetch() {
            return this.$store.state.storeCategory.listFetch;
        },
    },
    methods: {
        getResults(page = 1) {
            this.$store.dispatch('actionFetchCategory', { vue: this, params: { page: page } });
        },
        clickEdit(category) {
            this.$router.push({ name: 'main.category.edit', params: { id: category.id } });
        },
        async clickDelete(category) {
            return category.id
                && await this.$swal({
                    title: this.$i18n.t('textConfirmDelete'),
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }) 
                && this.$store.dispatch('actionCategoryDelete', { vue: this, id: category.id });
        },
    },
};
</script>
