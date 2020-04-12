<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Rule List</h3>
                    <router-link
                        :to="{ name: 'main.rule.add' }"
                        class="btn btn-success pull-right"
                    >
                        Add new rule
                    </router-link>
                    <button
                        class="btn btn-info btn-flat pull-right csv"
                        @click="clickCSV()"
                    >
                        Apply rules
                    </button>
                    <router-link
                        :to="{ name: 'main.rule.matrix' }"
                        class="btn btn-primary pull-right matrix"
                    >
                        See Matrix
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
                                        <th>Category</th>
                                        <th>Category</th>
                                        <th>Weight</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="rule in listFetch.data" :key="rule.id">
                                        <td>{{ rule.id }}</td>
                                        <td>{{ rule.category1 }}</td>
                                        <td>{{ rule.category2 }}</td>
                                        <td>{{ rule.weight }}</td>
                                        <td>
                                            <button
                                                class="btn btn-sm btn-warning btn-flat"
                                                @click="clickEdit(rule)"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="btn btn-sm btn-danger btn-flat"
                                                @click="clickDelete(rule)"
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
import axios from 'axios';

export default {
    name: 'Rule',
    components: {
        Pagination,
    },
    mounted() {
        this.getResults();
    },
    computed: {
        listFetch() {
            return this.$store.state.storeRule.listFetch;
        },
    },
    methods: {
        getResults(page = 1) {
            this.$store.dispatch('actionFetchRule', { vue: this, params: { page: page } });
        },
        clickEdit(rule) {
            this.$router.push({ name: 'main.rule.edit', params: { id: rule.id } });
        },
        async clickCSV() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await axios.post('/rules/csv');
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminMainLoading', { show: false });
        },
        async clickDelete(rule) {
            return rule.id
                && await this.$swal({
                    title: this.$i18n.t('textConfirmDelete'),
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }) 
                && this.$store.dispatch('actionRuleDelete', { vue: this, id: rule.id });
        },
    },
};
</script>
<style scoped>
    .matrix, .csv {
        margin-right: 10px;
    }
</style>