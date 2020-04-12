<template>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p v-if="auth_user">{{ auth_user.name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..." />
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu tree" data-widget="tree">
                <li>
                    <router-link :to="{ name: 'main.category' }">
                        <i class="fa fa-list-alt"></i> <span>Category</span>
                    </router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'main.rule' }">
                        <i class="fa fa-gavel"></i> <span>Rule</span>
                    </router-link>
                </li>
                <!-- <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Charts</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="pages/charts/chartjs.html"
                                ><i class="fa fa-circle-o"></i> ChartJS</a
                            >
                        </li>
                        <li>
                            <a href="pages/charts/morris.html"
                                ><i class="fa fa-circle-o"></i> Morris</a
                            >
                        </li>
                        <li>
                            <a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a>
                        </li>
                        <li>
                            <a href="pages/charts/inline.html"
                                ><i class="fa fa-circle-o"></i> Inline charts</a
                            >
                        </li>
                    </ul>
                </li> -->
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    name: 'AppAside',
    computed: {
        auth_user() {
            return this.$store.state.storeAuth.auth_user;
        },
    },
};
</script>
