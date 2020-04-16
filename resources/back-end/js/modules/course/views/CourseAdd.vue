<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add course</h3>
                </div>
                <form @submit.prevent="saveCourse" @keydown="form.onKeydown($event)">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <alert-error :form="form"></alert-error>
                            </div>
                            <div class="col-sm-8">
                                <input type="hidden" name="teacher_id" v-model="form.teacher_id">
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
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Price</label>
                                            <input
                                                v-model="form.price"
                                                type="text"
                                                name="price"
                                                class="form-control"
                                                placeholder="Enter price"
                                            />
                                            <has-error :form="form" field="price"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Level</label>
                                            <select
                                                v-model="form.level"
                                                name="level"
                                                class="form-control"
                                            >
                                                <option
                                                    v-for="level in this.levels"
                                                    v-bind:value="level.value"
                                                    v-bind:key="level.value"
                                                    >{{ level.name }}</option
                                                >
                                            </select>
                                            <has-error :form="form" field="level" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Category</label>
                                            <select
                                                v-model="form.courses_category_id"
                                                name="courses_category_id"
                                                class="form-control"
                                            >
                                                <option
                                                    v-for="category in this.categories"
                                                    v-bind:value="category.id"
                                                    v-bind:key="category.id"
                                                    >{{ category.name }}</option
                                                >
                                            </select>
                                            <has-error :form="form" field="courses_category_id" />
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail" @change="selectThumbnail" />
                                    <img src="/images/image_placeholder.png" alt="" class="preview"/>
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
    name: 'CourseAdd',
    components: {
        Form,
        HasError,
        AlertError,
    },
    mounted() {
        this.$store.dispatch('actionFetchCategory', { vue: this, params: {} });
        this.form.teacher_id = this.$store.state.storeAuth.auth_user.teacher_id;
    },
    data() {
        return {
            form: new Form({
                name: '',
                overview: '',
                price: '',
                level: '',
                teacher_id: '',
                courses_category_id: '',
                thumbnail: null,
            }),
            levels: [
                { name: 'Easy', value: 0 },
                { name: 'Medium', value: 1 },
                { name: 'Hard', value: 2 },
            ],
        };
    },
    computed: {
        categories() {
            return this.$store.state.storeCategory.listFetch.data;
        }
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
        async saveCourse() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await this.form.post('/courses', {
                    // Transform form data to FormData
                    transformRequest: [
                        function (data, headers) {
                            return objectToFormData(data);
                        },
                    ],
                });
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main.course' });
        },
    },
};
</script>
