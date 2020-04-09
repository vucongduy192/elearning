<template>
    <div class="blog">
        <div class="container">
            <div class="row row-lg-eq-height">
                <Blog_Category></Blog_Category>
                <Blog_List></Blog_List>
            </div>
        </div>
    </div>
</template>

<script>
    import Blog_Category from "./Blog_Category";
    import Blog_List from "./Blog_List";

    export default {
        name: "Blog_Intro",
        components: {
            Blog_List, Blog_Category
        }
    }
</script>

<style scoped>

</style>
