<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Admin List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <router-link
                                :to="{ name: 'main.user.add' }"
                                class="btn btn-success"
                            >
                                Add new admin
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
                                            ID <i class="sort fa fa-fw fa-sort-asc pull-right"></i>
                                        </th>
                                        <th id="name" @click="clickSort('name')">Name <i class="sort"></i></th>
                                        <th id="email" @click="clickSort('email')">Email <i class="sort"></i></th>
                                        <th id="role" @click="clickSort('role')">Role <i class="sort"></i></th>
                                        <th>Avatar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in listFetch.data" :key="user.id">
                                        <td>{{ user.id }}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.role }}</td>
                                        <td>
                                            <img :src="user.avatar" alt="" />
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning btn-flat"
                                                @click="clickEdit(user)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger btn-flat"
                                                @click="clickDelete(user)"
                                            >
                                                Delete
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
    name: 'User',
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
            this.$store.dispatch('actionFetchUser', { 
                vue: this, 
                params: {
                    page: page,
                    name: this.name,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
        },
        clickEdit(user) {
            this.$router.push({ name: 'main.user.edit', params: { id: user.id } });
        },
        async clickDelete(user) {
            return user.id
                && await this.$swal({
                    title: this.$i18n.t('textConfirmDelete'),
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }) 
                && this.$store.dispatch('actionUserDelete', { vue: this, id: user.id });
        },
    },
};
</script>
<style scoped>
    .matrix, .csv {
        margin-right: 10px;
    }
</style>