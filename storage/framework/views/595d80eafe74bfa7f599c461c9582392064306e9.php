<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/main_styles.css")); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/responsive.css")); ?>">
<style>
    .courses_row {
        margin-top: 20px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding" style="height: 120px;"></div>
<div class="courses">
    <div class="courses_background"></div>
    <div class="container">
        <?php if($recommend_by_enroll): ?>
        <div class="row">
            <div class="col">
                <h3 class="section_title">Có thể bạn thích</h3>
            </div>
        </div>
        <?php endif; ?>
        <div class="row courses_row">
            <!-- Course -->
            <?php $__currentLoopData = $recommend_by_enroll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 course_col">
                <div class="course">
                    <div class="course_image"><img
                            src="<?php echo e(asset($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL)); ?>"
                            alt=""></div>
                    <div class="course_body">
                        <div class="course_title">
                            <a href="<?php echo e(route('courses.show', ['id' => $course->id])); ?>"><?php echo e(mb_substr($course->name, 0, 21, "utf-8")); ?>


                            </a>
                        </div>
                        <div class="course_info">
                            <ul>
                                <li><a href="instructors.html"><?php echo e($course->teacher->user->name); ?></a></li>

                            </ul>
                        </div>
                        <div class="course_text">
                            <p><?php echo e($course->overview); ?></p>
                        </div>
                    </div>
                    <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                        <div class="course_students">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span><?php echo e($course->enrolls); ?></span>
                        </div>
                        <div class="course_rating ml-auto">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span><?php echo e((count($course->reviews) != 0) ? round($course->reviews->pluck('rating')->avg(), 0) : '0'); ?></span>
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
        <div style="clear: both; height: 60px;"></div>
        <div class="row">
            <div class="col">
                <h3 class="section_title">Gợi ý theo khảo sát</h3>
            </div>
        </div>
        <?php if(count($recommend_by_survey) == 0): ?>
            <div class="course_text">
                Không tìm thấy khóa học phù hợp với khảo sát. Làm lại <a href="<?php echo e(route('survey.show')); ?>">khảo sát</a>.
            </div>
        <?php endif; ?>
        <div class="row courses_row">
            <!-- Course -->
            <?php $__currentLoopData = $recommend_by_survey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 course_col">
                <div class="course">
                    <div class="course_image"><img
                            src="<?php echo e(asset($course->thumbnail ? $course->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL)); ?>"
                            alt=""></div>
                    <div class="course_body">
                        <div class="course_title">
                            <a href="<?php echo e(route('courses.show', ['id' => $course->id])); ?>"><?php echo e(mb_substr($course->name, 0, 21, "utf-8")); ?>


                            </a>
                        </div>
                        <div class="course_info">
                            <ul>
                                <li><a href="instructors.html"><?php echo e($course->teacher->user->name); ?></a></li>

                            </ul>
                        </div>
                        <div class="course_text">
                            <p><?php echo e($course->overview); ?></p>
                        </div>
                    </div>
                    <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                        <div class="course_students">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span><?php echo e($course->enrolls); ?></span>
                        </div>
                        <div class="course_rating ml-auto">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <span><?php echo e((count($course->reviews) != 0) ? round($course->reviews->pluck('rating')->avg(), 0) : '0'); ?></span>
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
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/recommend.blade.php ENDPATH**/ ?>