<template>
    <section class="content-header">
        <p>
            <ol class="breadcrumb">
                <li>
                    <a href="#" style="color: #000;">
                        <i class="fa fa-dashboard"></i>
                    </a>
                </li>
                <!-- <li v-if="b_parent.href !== ''">
                    <a :href="b_parent.href" style="color: #000;">
                        {{ b_parent.name }}
                    </a>
                </li> -->
                <li class="active">{{ breadcrumb }}</li>
            </ol>
        </p>
    </section>
</template>

<script>
export default {
    name: 'AppBreadcrumb',
    data() {
        return {
            b_parent: {href: '', name: ''}
        }
    },
    mounted() {
        // TO DO parent breadcrumb
        // console.log(this.$route.name, this.$route.path);
        // for (let action of ['add', 'edit']) {
        //     console.log(action);
        //     if (this.$route.name.includes(action)) {
        //         this.b_parent.href = this.$route.path.replace(`/${action}`, '');;
        //         this.b_parent.name = this.b_config[this.$route.name.replace(`.${action}`, '')];
        //         console.log(this.b_parent);
        //         break;
        //     }
        // }
    },
    computed: {
        b_config() {
            return this.$store.state.storeMain.breadcrumb;
        },
        breadcrumb() {
            return this.b_config[this.$route.name];
        },
    },
};
</script>
