<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit module</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <b>Course name:</b> {{ course.name }}
                        </div>
                    </div>
                </div>
                <form @submit.prevent="saveModule" @keydown="form.onKeydown($event)">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <alert-error :form="form"></alert-error>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="">Module name</label>
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
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="">Lectures manager</label>
                                    <button @click="addLecture" class="btn btn-success float-right">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div
                                    class="lecture"
                                    v-for="(lecture, counter) in form.lectures"
                                    v-bind:key="counter"
                                >
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                v-model="lecture.name"
                                                class="form-control"
                                                placeholder="Enter name"
                                            />
                                            <span class="input-group-btn">
                                                <button
                                                    @click="deleteLecture($event, counter)"
                                                    class="btn btn-danger"
                                                >
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </span>
                                        </div>
                                        <has-error
                                            :form="form"
                                            :field="`lectures.${counter}.name`"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="id[]" v-model="lecture.id" />
                                        <input
                                            type="file"
                                            :name="`slide${counter}`"
                                            @change="selectSlide($event, counter)"
                                        />
                                        <object
                                            type="application/pdf"
                                            :data="lecture.slide"
                                            :id="`preview_slide${counter}`"
                                        >
                                            <embed
                                                :id="`preview${counter}`"
                                                type="application/pdf"
                                            />
                                        </object>
                                        <has-error
                                            :form="form"
                                            :field="`lectures.${counter}.slide`"
                                        />
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
    name: 'ModuleEdit',
    components: {
        Form,
        HasError,
        AlertError,
    },
    async mounted() {
        await this.$store.dispatch('actionModuleShow', { vue: this, id: this.$route.params.id });
        let m = this.$store.state.storeModule.edit.data;
        Object.assign(this.form, m);
        this.course = m.course;
        console.log(m);
    },
    data() {
        return {
            form: new Form({
                name: '',
                overview: '',
                lectures: [],
            }),
            course: '',
        };
    },
    methods: {
        async saveModule() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                let contains_file = false;
                this.form.lectures.forEach((element) => {
                    if (element.slide.constructor === File) contains_file = true;
                });
                if (contains_file) {
                    const { data } = await this.form.post(`/modules/${this.$route.params.id}`, {
                        transformRequest: [
                            function (data, headers) {
                                data['_method'] = 'PUT';
                                return objectToFormData(data, { indices: true });
                            },
                        ],
                    });
                } else {
                    this.form.data['_method'] = 'PUT';
                    const { data } = await this.form.put(`/modules/${this.$route.params.id}`);
                }
            } catch (error) {
                this.$store.dispatch('setAdminMainLoading', { show: false });
                return;
            }
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main.course.edit', params: { id: this.course.id } });
        },
        selectSlide(e, counter) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(`#preview_slide${counter}`).attr('data', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
                this.form.lectures[counter].slide = e.target.files[0];
            }
        },
        addLecture(e) {
            e.preventDefault();
            this.form.lectures.push({
                id: -1,
                name: '',
                slide: '',
            });
        },
        deleteLecture(e, counter) {
            e.preventDefault();
            this.form.lectures.splice(counter, 1);
        },
    },
};
</script>
<style scoped></style>
