<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Add admin</h3>
                </div>
                <form @submit.prevent="saveAdmin" @keydown="form.onKeydown($event)">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <alert-error :form="form"></alert-error>
                            </div>
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
                                    <label for="">Email</label>
                                    <input
                                        v-model="form.email"
                                        type="text"
                                        name="email"
                                        class="form-control"
                                        placeholder="Enter name"
                                    />
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input
                                        v-model="form.password"
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Enter name"
                                    />
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="">Password Confimation</label>
                                    <input
                                        v-model="form.password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        class="form-control"
                                        placeholder="Enter name"
                                    />
                                    <has-error :form="form" field="password_confirmation"></has-error>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Avatar</label>
                                    <input type="file" name="avatar" @change="selectAvatar" />
                                    <img src="/images/image_placeholder.png" alt="" class="preview"/>
                                    <has-error :form="form" field="avatar"></has-error>
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
    name: 'CategoryAdd',
    components: {
        Form,
        HasError,
        AlertError,
    },
    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                avatar: null,
            }),
        };
    },
    methods: {
        selectAvatar(e) {
            if (e.target.files && e.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);

                this.form.avatar = e.target.files[0];
            }
        },
        async saveAdmin() {
            this.$store.dispatch('setAdminMainLoading', { show: true });
            try {
                const { data } = await this.form.post('/users', {
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
            this.$router.push({ name: 'main.user' });
        },
    },
};
</script>
