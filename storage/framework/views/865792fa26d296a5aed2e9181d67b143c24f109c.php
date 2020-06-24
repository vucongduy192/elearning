<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/instructors.css")); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/instructors_responsive.css")); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding professor_header" style="height: 500px;"></div>

<div class="video">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="video_content">
                    <div class="video_container_outer">
                        <div class="video_overlay d-flex flex-column align-items-start justify-content-center">



                        </div>
                        <div class="video_container">




                            <video controls width="100%" height="100%">
                                <source src="<?php echo e(asset('intro.mp4')); ?>" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    <?php if(\Illuminate\Support\Facades\Auth::user() == null): ?>
                    <div class="register_button">
                        <a href="<?php echo e(route('register')); ?>">Đăng ký ngay</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="instructors">
    <div class="instructors_background"
        style="background-image: url(<?php echo e(asset('front-end/images/instructors_background.png')); ?>)"></div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">Giảng viên được yêu thích</h2>
            </div>
        </div>
        <div class="row instructors_row">
            <?php $__currentLoopData = $best_teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $professor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <!-- Instructor -->
            <div class="col-lg-4 instructor_col">
                <div class="instructor text-center">
                    <div class="instructor_image_container">
                        <div class="instructor_image"><img
                                src="<?php echo e(asset($professor->user->avatar ? $professor->user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR)); ?>"
                                alt=""></div>
                    </div>
                    <div class="instructor_name"><a href="<?php echo e(route('professors.show', ['id' => $professor->id])); ?>">
                            <?php echo e($professor->user->name); ?></a></div>
                    <div class="instructor_title"><?php echo e($professor->expert); ?></div>
                    <div class="instructor_text">
                        <p><?php echo e($professor->workplace); ?></p>
                    </div>
                    <div class="instructor_social">
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>
    </div>
</div>

<div class="teachers">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">Giảng viên trong từng chuyên ng</h2>
            </div>
        </div>
        <div class="row teachers_row">
            <?php $__currentLoopData = $best_teacher_in_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $professor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!empty($professor)): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="teacher d-flex flex-row align-items-center justify-content-start">
                        <div class="teacher_image">
                            <div><img
                                    src="<?php echo e(asset($professor->user->avatar ? $professor->user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR)); ?>"
                                    alt=""></div>
                        </div>
                        <div class="teacher_content">
                            <div class="teacher_name">
                                <a href="<?php echo e(route('professors.show', ['id' => $professor->id])); ?>">
                                    <?php echo e($professor->user->name); ?>

                                </a>
                            </div>
                            <div class="teacher_title"><?php echo e($professor->expert); ?></div>
                            <div class="teacher_title"><?php echo e($category); ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/professors.blade.php ENDPATH**/ ?>