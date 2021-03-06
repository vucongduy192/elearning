<?php if(count($enrolled) == 0): ?>
<div class="course_body">
    <div class="course_text">
        Bạn chưa có dữ liệu lịch sử học.
    </div>
</div>
<?php endif; ?>

<?php $__currentLoopData = $enrolled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="course_body">
    <div class="course_title">
        <a href="#"> <?php echo e($enroll->course->name); ?></a>
    </div>
    <div>
        <a href="<?php echo e(route('courses.show', ['id' => $enroll->course->id])); ?>" class="btn btn-primary e-btn pull-right">
            Tiếp tục học
        </a>
    </div>
    <br>
    <div class="course_info">
        <ul>
            <li><a href="#"><b> <?php echo e($enroll->course->teacher->user->name); ?></b></a></li>
        </ul>
    </div>
    <div class="course_text">
        <p><?php echo e($enroll->course->overview); ?></p>
    </div>
</div>
<br>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="pull-right">
    <?php echo e($enrolled->links('components.pagination')); ?>

</div>
<?php /**PATH /var/www/resources/views/components/enrolled_list.blade.php ENDPATH**/ ?>