<template>
    <router-view></router-view>
</template>

<script>
import axios from 'axios';

export default {
    name: 'App',
    mounted() {
    },
    async created() {
        await this.$store.dispatch('fetchUser');
    }
};
</script>
