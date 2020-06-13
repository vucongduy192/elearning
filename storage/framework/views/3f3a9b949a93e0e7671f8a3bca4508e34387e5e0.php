<?php if(count($courses) == 0): ?>
<script>
    toastr.warning('Professor don\'t upload any courses.');
</script>
<?php endif; ?>

<?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="course_body">
    <div class="course_title" style="display: inline-block;">
        <a href="#"> <?php echo e($course->name); ?></a>
    </div>
    <a href="<?php echo e(route('courses.show', ['id' => $course->id])); ?>" class="btn btn-primary e-btn pull-right">
        Go to course
    </a>
    <br>
    <div class="course_text">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
    </div>
</div>
<br>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="pull-right">
    <?php echo e($courses->links('components.pagination')); ?>

</div>
<?php /**PATH /var/www/resources/views/components/professor_courses_list.blade.php ENDPATH**/ ?>