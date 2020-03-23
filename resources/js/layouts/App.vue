<template>
    <div>
        <div class="super_container">
            <main>
                <router-view></router-view>
                    <Navbar></Navbar>
                    <Footer></Footer>
            </main>
        </div>
    </div>
</template>

<script>
    import Navbar from '../components/Navbar.vue';
    import Footer from '../components/Footer.vue';


    export default {
        name: "app",
        components: {
            Footer, Navbar
        }
    }
</script>

<style scoped>

</style>
