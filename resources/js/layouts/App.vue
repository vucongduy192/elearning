<template>
    <div>
        <div class="super_container">
            <Navbar></Navbar>
            <main>
                <router-view></router-view>
            </main>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
    import Navbar from '../includes/Navbar.vue';
    import Footer from '../includes/Footer.vue';


    export default {
        name: "app",
        components: {
            Footer, Navbar
        }
    }
</script>

<style scoped>

</style>
