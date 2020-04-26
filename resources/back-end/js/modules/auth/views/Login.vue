<template>
    <div class="login-box">
        <div class="login-box-body">
            <!-- /.login-logo -->
            <div class="login-logo">
                <a href="#"><b>E-Learning</b></a>
            </div>
            <p class="login-box-msg">Sign in to start your session</p>
            <form @submit.prevent="login" @keydown="form.onKeydown($event)">
                <alert-error :form="form"></alert-error>
                <div class="form-group has-feedback">
                    <input
                        v-model="form.email"
                        type="text"
                        name="username"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                        placeholder="Email"
                    />
                    <i class="fa fa-envelope form-control-feedback" aria-hidden="true"></i>
                    <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group has-feedback">
                    <input
                        v-model="form.password"
                        type="password"
                        name="password"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                        placeholder="Password"
                    />
                    <i class="fa fa-key form-control-feedback" aria-hidden="true"></i>
                    <has-error :form="form" field="password"></has-error>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox">
                            <label>
                                <input v-model="form.remember" type="checkbox" name="remember" />
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button
                            :disabled="form.busy"
                            type="submit"
                            class="btn btn-primary btn-block btn-flat"
                        >
                            Log In
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
</template>
<script>
import { Form, HasError, AlertError } from 'vform';

export default {
    name: 'Login',
    components: {
        Form,
        HasError,
        AlertError,
    },
    data() {
        return {
            form: new Form({
                email: '',
                password: '',
                remember: false,
            }),
        };
    },
    methods: {
        async login() {
            this.$store.dispatch('setAdminLoading', { show: true });
            try {
                const { data } = await this.form.post('/login');
                // Save token
                this.$store.dispatch('saveToken', {
                    token: data.token,
                    remember: this.remember,
                });
            } catch (error) {
                this.$store.dispatch('setAdminLoading', { show: false });
                return;
            }
            // Fetch the user.
            await this.$store.dispatch('fetchUser');
            this.$store.dispatch('setAdminLoading', { show: false });
            this.$router.push({ name: 'main'});
        },
    },
};
</script>
<style>
    body {
        background: lightgray;
    }
</style>