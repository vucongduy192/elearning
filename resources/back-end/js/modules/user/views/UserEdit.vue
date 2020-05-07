<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit user</h3>
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
                                <div class="row">
                                    <div class="col-sm-8">
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
                                            <label for="">Role</label>
                                            <select
                                                v-model="form.role_id"
                                                name="role_id"
                                                class="form-control"
                                            >
                                                <option
                                                    v-for="(role, index) in roles"
                                                    v-bind:value="index"
                                                    v-bind:key="index"
                                                    :selected="form.role_id == index"
                                                >{{ role }}</option
                                                >
                                            </select>
                                            <has-error :form="form" field="role_id" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Avatar</label>
                                    <input type="file" name="avatar" @change="selectAvatar" />
                                    <img :src="form.avatar" alt="" class="preview"/>
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
    name: 'CategoryEdit',
    components: {
        Form,
        HasError,
        AlertError,
    },
    async mounted() {
        await this.$store.dispatch('actionUserShow', { vue: this, id: this.$route.params.id });
        let user = this.$store.state.storeUser.edit.data;
        this.form.name = user.name;
        this.form.email = user.email;
        this.form.role_id = user.role_id;
        this.form.avatar = user.avatar;
    },
    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                avatar: null,
                role_id: null
            }),
            roles: ['Student', 'Teacher', 'Admin',]
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
                if (this.form.avatar.constructor === File) {
                    const { data } = await this.form.post(`/users/${this.$route.params.id}`, {
                        transformRequest: [
                            function (data, headers) {
                                data['_method'] = 'PUT';
                                return objectToFormData(data);
                            },
                        ],
                    });
                } else {
                    this.form.data['_method'] = 'PUT';
                    const { data } = await this.form.put(`/users/${this.$route.params.id}`);
                }
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
