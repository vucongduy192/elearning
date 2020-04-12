<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add rule</h3>
                </div>
                <form @submit.prevent="saveRule" @keydown="form.onKeydown($event)">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <alert-error :form="form"></alert-error>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Category 1</label>
                                    <select
                                        v-model="form.cat_id1"
                                        name="cat_id1"
                                        class="form-control"
                                    >
                                        <option
                                            v-for="category in categories"
                                            v-bind:value="category.id"
                                            v-bind:key="category.id"
                                            >{{ category.name }}</option
                                        >
                                    </select>
                                    <has-error :form="form" field="cat_id1" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Category 2</label>
                                    <select
                                        v-model="form.cat_id2"
                                        name="cat_id2"
                                        class="form-control"
                                    >
                                        <option
                                            v-for="category in categories"
                                            v-bind:value="category.id"
                                            v-bind:key="category.id"
                                            :disabled="form.cat_id1 == category.id"
                                            >{{ category.name }}</option
                                        >
                                    </select>
                                    <has-error :form="form" field="cat_id2" />
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="">Weight</label>
                                     <select
                                        v-model="form.weight"
                                        name="weight"
                                        class="form-control"
                                    >
                                        <option
                                            v-for="w in Array.from({ length: 10 }, (_, i) => (i+1)/10)"
                                            v-bind:value="w"
                                            v-bind:key="w"
                                            >{{ w }}</option
                                        >
                                    </select>
                                    <has-error :form="form" field="weight"></has-error>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button :disabled="form.busy" type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
</template>

<script>
import { Form, HasError, AlertError } from 'vform';

export default {
    name: 'RuleAdd',
    components: {
        Form,
        HasError,
        AlertError,
    },
    mounted() {
        this.$store.dispatch('actionFetchCategory', { vue: this, params: {} });
    },
    data() {
        return {
            form: new Form({
                cat_id1: '',
                cat_id2: '',
                weight: '',
            }),
        };
    },
    computed: {
        categories() {
            return this.$store.state.storeCategory.listFetch.data;
        },
    },
    methods: {
        async saveRule() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await this.form.post('/rules');
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main.rule' });
        },
    },
};
</script>
