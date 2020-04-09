 <template>
    <div>
        <Banner></Banner>
        <div class="courses">
            <div class="courses_background"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="section_title text-center">Popular Online Courses</h2>
                    </div>
                </div>
                <Course_List></Course_List>
            </div>
        </div>
        <div class="instructors">
            <div class="instructors_background" style="background-image:url(assets/images/instructors_background.png)"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h2 class="section_title text-center">The Best Tutors in Town</h2>
                    </div>
                </div>
                <Professor_List></Professor_List>
            </div>
        </div>
        <Contact_Form></Contact_Form>
        <Blog_Intro></Blog_Intro>
    </div>
</template>

<script>
    import Course_List from "../components/course/Course_List";
    import Professor_List from "../components/professor/Professor_List";
    import Blog_Intro from "../components/blog/Blog_Intro";
    import Banner from "../includes/Banner";
    import Contact_Form from "../components/contact/Contact_Form"

    export default {
        name: 'Home',
        components: {
            Course_List, Professor_List, Blog_Intro, Banner, Contact_Form
        }
    }
</script>

<style scoped>

</style>
