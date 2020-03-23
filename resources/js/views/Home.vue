 <template>
    <div>
        <h1>Test</h1>
    </div>
</template>

<script>
    import Course_List from "../components/course/Course_List";
    import Professor_List from "../components/professor/Professor_List";
    import Blog_Category from "../components/blog/Blog_Category";
    import Blog_List from "../components/blog/Blog_List";
    import Banner from "../components/includes/Banner";

    export default {
        name: 'home',
        components: {
            Course_List, Professor_List, Blog_List, Blog_Category
        }
    }
</script>

<style scoped>

</style>
