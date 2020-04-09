<template>
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
</template>

<script>
    import Professor_List from "../components/professor/Professor_List";
    export default {
        components: {
            Professor_List
        }
    }
</script>

<style scoped>

</style>
