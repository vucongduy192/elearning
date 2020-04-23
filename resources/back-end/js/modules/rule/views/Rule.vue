<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Rule List</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <router-link
                                :to="{ name: 'main.rule.add' }"
                                class="btn btn-success"
                            >
                                Add new rule
                            </router-link>
                            <button
                                class="btn btn-info btn-flat csv"
                                @click="clickCSV()"
                            >
                                Apply rules
                            </button>
                            <router-link
                                :to="{ name: 'main.rule.matrix' }"
                                class="btn btn-primary matrix"
                            >
                                See Matrix
                            </router-link>
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
                                        <th id="cat_id1" @click="clickSort('cat_id1')">Category <i class="sort"></i></th>
                                        <th id="cat_id2" @click="clickSort('cat_id2')">Category <i class="sort"></i></th>
                                        <th id="weight" @click="clickSort('weight')">Weight <i class="sort"></i></th>
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
    data() {
        return {
            sortColumn: 'id',
            sortType: 'desc',
        };
    },
    computed: {
        listFetch() {
            return this.$store.state.storeRule.listFetch;
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
            this.$store.dispatch('actionFetchRule', { 
                vue: this, 
                params: {
                    page: page,
                    sortColumn: this.sortColumn,
                    sortType: this.sortType,
                },
            });
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