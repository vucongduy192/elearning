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
                                <input type="hidden" name="teacher_id" v-model="form.teacher_id" />
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
                                    <label for="">Name (english)</label>
                                    <input
                                        v-model="form.name_en"
                                        type="text"
                                        name="name_en"
                                        class="form-control"
                                        placeholder="Enter name (english)"
                                    />
                                    <has-error :form="form" field="name_en"></has-error>
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
                                                placeholder="Enter price (dollar)"
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
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Duration</label>
                                            <select
                                                v-model="form.duration_id"
                                                name="duration_id"
                                                class="form-control"
                                            >
                                                <option
                                                    v-for="duration in this.durations"
                                                    v-bind:value="duration.id"
                                                    v-bind:key="duration.id"
                                                    >{{ duration.name }}</option
                                                >
                                            </select>
                                            <has-error :form="form" field="duration_id" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="">Partner</label>
                                            <select
                                                v-model="form.partner_id"
                                                name="partner_id"
                                                class="form-control"
                                            >
                                                <option
                                                    v-for="partner in this.partners"
                                                    v-bind:value="partner.id"
                                                    v-bind:key="partner.id"
                                                    >{{ partner.name }}</option
                                                >
                                            </select>
                                            <has-error :form="form" field="partner_id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail" @change="selectThumbnail" />
                                    <img
                                        src="/images/image_placeholder.png"
                                        alt=""
                                        class="preview"
                                    />
                                    <has-error :form="form" field="thumbnail"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="">Modules manager</label>
                                    <button @click="addModule" class="btn btn-success float-right">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div
                                    class="module"
                                    v-for="(m, counter) in form.modules"
                                    v-bind:key="counter"
                                >
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                v-model="m.name"
                                                class="form-control"
                                                placeholder="Enter name"
                                            />
                                            <span class="input-group-btn">
                                                <button
                                                    @click="deleteModule($event, counter)"
                                                    class="btn btn-danger"
                                                >
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <has-error
                                            :form="form"
                                            :field="`modules.${counter}.name`"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <textarea
                                            v-model="m.overview"
                                            rows="3"
                                            class="form-control"
                                        ></textarea>
                                    </div>
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
        this.$store.dispatch('actionFetchDuration');
        this.$store.dispatch('actionFetchPartner');
        this.form.teacher_id = this.$store.state.storeAuth.auth_user.teacher_id;
    },
    data() {
        return {
            form: new Form({
                name: '',
                name_en: '',
                overview: '',
                price: '',
                level: '',
                teacher_id: '',
                duration_id: '',
                partner_id: '',
                courses_category_id: '',
                thumbnail: null,
                modules: [
                    {
                        name: '',
                        overview: '',
                    },
                ],
            }),
            levels: [
                { name: 'Easy', value: 1 },
                { name: 'Medium', value: 2 },
                { name: 'Hard', value: 3 },
            ],
        };
    },
    computed: {
        categories() {
            return this.$store.state.storeCategory.listFetch.data;
        },
        durations() {
            return this.$store.state.storeCourse.durations;
        },
        partners() {
            return this.$store.state.storeCourse.partners;
        },
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
                            return objectToFormData(data, { indices: true });
                        },
                    ],
                });
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main.course' }, () => {
                this.$store.dispatch('pushSuccessNotify', {msg: this.$i18n.t('textAddCourseSuccess')})
            });
        },
        addModule(e) {
            e.preventDefault();
            this.form.modules.push({
                name: '',
                overview: '',
            });
        },
        deleteModule(e, counter) {
            e.preventDefault();
            this.form.lectures.splice(counter, 1);
        },
    },
};
</script>
