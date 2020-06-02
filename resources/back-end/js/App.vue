<template>
    <router-view></router-view>
</template>

<script>
import axios from 'axios';

export default {
    name: 'App',
    mounted() {
        if (store.state.storeAuth.token) {
            let existed_token = JSON.parse(store.state.storeAuth.token);
            axios.defaults.headers.common[
                'Authorization'
            ] = `${existed_token.token_type} ${existed_token.access_token}`;
        }
    },
    async created() {
        await this.$store.dispatch('fetchUser');
    }
};
</script>
