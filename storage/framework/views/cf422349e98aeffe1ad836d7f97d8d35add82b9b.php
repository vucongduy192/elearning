<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/main_styles.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/responsive.css")); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding" style="height: 20px;"></div>
<div class="auth" style="padding-bottom: 60px;">
    <div class="container-fluid">
        <div class="row auth_row">
            <div class="col-md-3">
                <div class="course_body">
                    <div class="course_title">
                        <a href="#"><?php echo e($lecture->module->course->name); ?></a>
                    </div>
                    <div class="course_info">
                        <ul>
                            <li><a href="instructors.html"><?php echo e($lecture->module->course->teacher->user->name); ?></a></li>
                            <li><a href="#">English</a></li>
                        </ul>
                    </div>
                    <div class="course_text">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce enim nulla.</p>
                    </div>
                </div>
                <br>
                <div class="course_body">
                    <?php $__currentLoopData = $allModules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row">
                        <div class="col-md-10 lecture_title">
                            <span class="cur_item_title_before"><?php echo e($key + 1); ?></span>
                            <?php echo e($module->name); ?>

                        </div>
                        <div class="col-md-2 pull-right">
                            <form action="#" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-group template-checkbox">
                                    <input class="process" type="checkbox"
                                           name="module<?php echo e($module->id); ?>" id="module<?php echo e($module->id); ?>"
                                           <?php echo e(in_array($module->id, $module_processed) ? 'checked' : ''); ?>

                                           data-course_id="<?php echo e($lecture->module->course->id); ?>" data-module_id="<?php echo e($module->id); ?>"
                                           data-student_id="<?php echo e(\Illuminate\Support\Facades\Auth::user()->student->id); ?>">
                                    <label for="module<?php echo e($module->id); ?>"></label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="cur_item_content">
                        <div class="cur_contents sidebar_cur_contents">
                            <ul>
                                <?php $__currentLoopData = $module->lectures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $urls = explode('/', Request::url()); ?>
                                <li>
                                    <?php $filetype = explode(".", $l->slide); ?>
                                    <?php if(end($filetype) == 'pdf'): ?>
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                    <?php else: ?>
                                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                                    <?php endif; ?>
                                    <span>
                                        <a class="lecture_link"
                                            style="font-weight: <?php echo e(end($urls)==$l->id ? 'bold' : ''); ?>"
                                            href="<?php echo e(route('lectures.show', ['id' => $l->id])); ?>">
                                            <?php echo e($l->name); ?>

                                        </a>
                                    </span>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                    <br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-md-9">
                <object type="application/pdf" data="<?php echo e($lecture->slide); ?>">
                    <embed type="application/pdf">
                </object>
                <div class="course_footer d-flex flex-row align-items-center justify-content-start">
                    <div class="course_students"><i class="fa fa-user" aria-hidden="true"></i><span>86</span></div>
                    <div class="course_rating ml-auto"><i class="fa fa-star" aria-hidden="true"></i><span>4.5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        $('.process').click(function () {
            console.log();
            var url = "<?php echo e(route('processes.store')); ?>", method = "POST";
            if (!$(this).is(':checked')) {
                url = "<?php echo e(route('processes.destroy')); ?>";
                method = "DELETE";
            }
            $.ajax({
                url: url,
                method: method,
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    course_id: $(this).data("course_id"),
                    module_id: $(this).data("module_id"),
                    student_id: $(this).data("student_id"),
                },
                success: function (data) {
                    toastr.success(data.message);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/lecture_details.blade.php ENDPATH**/ ?>