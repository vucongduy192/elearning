<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit category</h3>
                </div>
                <form @submit.prevent="saveCategory" @keydown="form.onKeydown($event)">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        placeholder="Enter name"
                                    />
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="">Overview</label>
                                    <textarea
                                        v-model="form.overview"
                                        class="form-control"
                                        placeholder="Enter overview"
                                    />
                                    <has-error :form="form" field="overview"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail" @change="selectThumbnail" />
                                    <img :src="form.thumbnail" alt="" class="preview" />
                                    <has-error :form="form" field="thumbnail"></has-error>
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
import { objectToFormData } from 'object-to-formdata';

export default {
    name: 'CategoryEdit',
    components: {
        Form,
        HasError,
        AlertError,
    },
    async mounted() {
        await this.$store.dispatch('actionCategoryShow', { vue: this, id: this.$route.params.id });
        let category = this.$store.state.storeCategory.edit.data;
        this.form.name = category.name;
        this.form.overview = category.overview;
        this.form.thumbnail = category.thumbnail;
    },
    data() {
        return {
            form: new Form({
                name: '',
                overview: '',
                thumbnail: null,
            }),
        };
    },
    methods: {
        selectThumbnail(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
                this.form.thumbnail = e.target.files[0];
            }
        },
        async saveCategory() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                if (this.form.thumbnail.constructor === File) {
                    const { data } = await this.form.post(`/categories/${this.$route.params.id}`, {
                        transformRequest: [
                            function (data, headers) {
                                data['_method'] = 'PUT';
                                return objectToFormData(data);
                            },
                        ],
                    });
                } else {
                    const { data } = await this.form.put(`/categories/${this.$route.params.id}`);
                }
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main.category' });
        },
    },
};
</script>
