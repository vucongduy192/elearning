<?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="review">
    <div
        class="review_title_container d-flex flex-row align-items-start justify-content-start">
        <div
            class="review_title d-flex flex-row align-items-center justify-content-center">
            <div class="review_author_image">
                <div><img src="#" alt=""></div>
            </div>
            <div class="review_author">
                <div class="review_author_name"><a href="#"><?php echo e($r->student->user->name); ?></a></div>
                <div class="review_date"><?php echo e(date('d/m/Y', strtotime($r->created_at))); ?></div>
            </div>
        </div>
        <div class="review_stars ml-auto">
            <div class="rating_r rating_r_<?php echo e($r->rating); ?> review_rating">
                <i></i>
                <i></i>
                <i></i>
                <i></i>
                <i></i></div>
        </div>
    </div>
    <div class="review_text">
        <p><?php echo e($r->content); ?></p>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="pull-right">
    <?php echo e($reviews->links('components.pagination')); ?>

</div>
<?php /**PATH /var/www/resources/views/components/reviews_list.blade.php ENDPATH**/ ?>