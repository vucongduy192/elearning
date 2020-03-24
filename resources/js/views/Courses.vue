<template>
    <div class="courses">
        <div class="courses_background"></div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <Course_Category></Course_Category>
                </div>
            </div>
            <Course_List></Course_List>
        </div>
    </div>
</template>

<script>
    import Course_Category from "../components/course/Course_Category";
    import Course_List from "../components/course/Course_List";

    export default {
        components: {
            Course_Category, Course_List
        }
    }
</script>

<style scoped>
    .courses {
        padding-top: 80px;
    }
</style>
