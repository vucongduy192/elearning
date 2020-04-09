<template>
    <div class="wrapper" style="height: auto; min-height: 100%;">
        <app-header></app-header>
        <app-aside></app-aside>
        <div class="content-wrapper">
            <app-breadcrumb></app-breadcrumb>
            <section class="content">
                <router-view></router-view>
            </section>
        </div>
        <app-footer></app-footer>
        <app-control-siderbar></app-control-siderbar>
        <div class="control-sidebar-bg"></div>
    </div>
</template>

<script>
import AppHeader from "*/components/Header";
import AppAside from "*/components/Aside";
import AppBreadcrumb from "*/components/Breadcrumb";
import AppFooter from "*/components/Footer";
import AppControlSiderbar from "*/components/ControlSidebar";

export default {
    name: "App",
    components: {
        AppHeader,
        AppAside,
        AppBreadcrumb,
        AppControlSiderbar,
        AppFooter,
    },
};
</script>
