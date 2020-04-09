<template>
    <div>
        <div class="splash-screen" v-show="loading.show">
            <div class="splash-overlay" v-show="loading.show"></div>
            <div class="splash-spinner"></div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>

export default {
    name: 'App',
    async created() {
        await this.$store.dispatch('fetchUser');
    },
    computed: {
        loading() {
            return this.$store.state.storeLoading.loading
        },
    }
};
</script>
