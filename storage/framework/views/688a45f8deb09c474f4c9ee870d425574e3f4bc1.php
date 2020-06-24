<div class="row courses_row">
    <?php if(count($courses) == 0): ?>
    <div class="course_body" style="width: 100%; margin-left: 15px; margin-right: 15px;">
        <div class="course_text">
            Không tìm thấy khóa học phù hợp
        </div>
    </div>
    <?php endif; ?>

    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-4 col-md-6 col-xs-6 course_col">
        <div class="course">
            <div class="course_image">
                <img src="<?php echo e($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL); ?>"
                    alt="">
            </div>
            <div class="course_body">
                <div class="course_title">
                    <a href="<?php echo e(route('courses.show', ['id' => $course->id])); ?>"><?php echo e(mb_substr($course->name, 0, 21, "utf-8")); ?>

                    </a>
                </div>
                <div class="course_info">
                    <ul>
                        <li><a
                                href="<?php echo e(route('professors.show', ['id' => $course->teacher->id])); ?>"><?php echo e($course->teacher->user->name); ?></a>
                        </li>

                    </ul>
                </div>
                <div class="course_text">
                    <p><?php echo e($course->overview); ?></p>
                </div>
            </div>
            <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                <div class="course_students"><i class="fa fa-user"
                        aria-hidden="true"></i><span><?php echo e($course->enrolls); ?></span></div>
                <div class="course_rating ml-auto"><i class="fa fa-star"
                        aria-hidden="true"></i><span><?php echo e((count($course->reviews) != 0) ? round($course->reviews->pluck('rating')->avg(), 0) : '0'); ?></span>
                </div>
                <?php if($course->price == 0): ?>
                <div class="course_mark course_free trans_200"><a href="#">Free</a></div>
                <?php else: ?>
                <div class="course_mark trans_200"><a href="#">$<?php echo e($course->price); ?></a></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="pull-right">
    <?php echo e($courses->links('components.pagination')); ?>

</div>
<?php /**PATH /var/www/resources/views/components/courses_list.blade.php ENDPATH**/ ?>