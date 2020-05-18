<template>
    <div class="wrapper" style="height: auto; min-height: 100%;">
        <div class="splash-screen" v-show="loading.show">
            <div class="splash-overlay" v-show="loading.show"></div>
            <div class="splash-spinner"></div>
        </div>
        <app-header></app-header>
        <app-aside></app-aside>
        <div class="content-wrapper">
            <div class="splash-screen" v-show="mainLoading.show">
                <div class="splash-overlay" v-show="mainLoading.show"></div>
                <div class="splash-spinner"></div>
            </div>
            <app-breadcrumb></app-breadcrumb>
            <section class="content">
                <router-view :key="$route.fullPath"></router-view>
            </section>
        </div>
        <app-footer></app-footer>
        <app-control-siderbar></app-control-siderbar>
        <app-modal></app-modal>
        <div class="control-sidebar-bg"></div>
    </div>
</template>

<script>
import AppHeader from '*/components/Header';
import AppAside from '*/components/Aside';
import AppBreadcrumb from '*/components/Breadcrumb';
import AppFooter from '*/components/Footer';
import AppControlSiderbar from '*/components/ControlSidebar';
import AppModal from '*/components/Modal';

export default {
    name: 'Main',
    components: {
        AppHeader,
        AppAside,
        AppBreadcrumb,
        AppControlSiderbar,
        AppFooter,
        AppModal,
    },
    computed: {
        loading() {
            return this.$store.state.storeLoading.loading;
        },
        mainLoading() {
            return this.$store.state.storeLoading.mainLoading;
        },
    },
};
</script>
