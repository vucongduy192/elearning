<template>
    <router-view></router-view>
</template>

<script>
export default {
    name: 'App',
    async created() {
        await this.$store.dispatch('fetchUser');
    }
};
</script>
