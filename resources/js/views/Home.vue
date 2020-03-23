 <template>
    <div>
        <div class="home">
            <div class="home_background" style="background-image: url('assets/images/index_background.jpg');"></div>
            <div class="home_content">
                <div class="container">
                    <div class="row">
                        <div class="col text-center">
                            <h1 class="home_title">Learn Languages Easily</h1>
                            <div class="home_button trans_200"><a href="#">get started</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <course_list></course_list>
        <professor_list></professor_list>
        <Blog></Blog>
    </div>
</template>

<script>
    import Course from "../components/course/Course_List";
    import Professor from "../components/professor/Professor_List";
    import Blog from "../components/blog/Blog_Category";

    export default {
        name: 'home',
        components: {
            Course, Professor, Blog
        }
    }
</script>

<style scoped>

</style>
