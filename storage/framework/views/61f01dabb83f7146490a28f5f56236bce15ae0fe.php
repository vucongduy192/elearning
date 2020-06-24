<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/course.css")); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/course_responsive.css")); ?>">
<style>
    .cur_contents {
        margin-top: 5px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding" style="height: 120px;"></div>

<div class="intro">
    <img class="intro_background parallax-window" data-parallax="scroll" src="<?php echo e(asset('front-end/images/intro.jpg')); ?>"
        data-speed="0.8" alt="">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="intro_container d-flex flex-column align-items-start justify-content-end">
                    <div class="intro_content">
                        <div class="intro_price">Free</div>
                        <div class="rating_r rating_r_4 intro_rating"></div>
                        <div class="intro_title"><?php echo e($course->name); ?></div>
                        <div class="intro_meta">
                            <div class="intro_image">
                                <img src="<?php echo e(asset($course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_AVATAR)); ?>"
                                    alt="">
                            </div>
                            <div class="intro_instructors">
                                <a href="#"><?php echo e($course->teacher->user->name); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="course">
    <div class="course_top"></div>
    <div class="container">
        <div class="row row-lg-eq-height">

            <!-- Panels -->
            <div class="col-lg-9">
                <div class="tab_panels">
                    <!-- Tabs -->
                    <div class="course_tabs_container">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="tabs nav nav-tabs d-flex flex-row align-items-center justify-content-start"
                                        role="tablist">
                                        <a class="nav-link active" data-toggle="tab" href="#description">Mô tả</a>
                                        <a class="nav-link" data-toggle="tab" href="#syllabus">Lộ trình</a>
                                        <a class="nav-link" data-toggle="tab" href="#reviews">Đánh giá</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <!-- Description -->
                        <div id="description" class="tab-pane tab_panel description active">
                            <div class="panel_title">Thông tin khóa học</div>
                            <div class="panel_text">
                                <p><?php echo e($course->overview); ?></p>
                            </div>
                            <br>
                            <div class="panel_title">Về giảng viên</div>
                            <div class="row instructors_row">

                                <!-- Instructor -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="instructor d-flex flex-row align-items-center justify-content-start">
                                        <div class="instructor_image">
                                            <div><img
                                                    src="<?php echo e(asset($course->teacher->avatar ? $course->teacher->avatar : \App\Models\Config::PLACEHOLDER_AVATAR)); ?>"
                                                    alt=""></div>
                                        </div>
                                        <div class="instructor_content">
                                            <div class="instructor_name"><a
                                                    href="#"><?php echo e($course->teacher->user->name); ?></a>
                                            </div>
                                            <div class="instructor_title"><?php echo e($course->teacher->expert); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Curriculum -->
                        <div id="syllabus" class="tab-pane tab_panel curriculum fade">
                            <div class="curriculum_items">
                                <?php $__currentLoopData = $course->modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="cur_item">
                                    <div class="cur_item_content">
                                        <span class="cur_item_title_before"><?php echo e($key + 1); ?></span>
                                        <div class="pull-right">
                                            <div class="form-group template-checkbox">
                                                <?php if($has_enrolled): ?>
                                                <input class="process" type="checkbox" name="module<?php echo e($module->id); ?>"
                                                    id="module<?php echo e($module->id); ?>"
                                                    <?php echo e(in_array($module->id, $module_processed) ? 'checked' : ''); ?>

                                                    data-course_id="<?php echo e($course->id); ?>"
                                                    data-module_id="<?php echo e($module->id); ?>"
                                                    data-student_id="<?php echo e(\Illuminate\Support\Facades\Auth::user()->student->id); ?>">
                                                <label for="module<?php echo e($module->id); ?>"></label>
                                                <?php else: ?>
                                                <input class="process" type="checkbox" id="module-none">
                                                <label for="module-none"></label>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="cur_item_title"><?php echo e($module->name); ?></div>
                                        <div class="cur_item_text">
                                            <p><?php echo e($module->overview); ?></p>
                                        </div>

                                        <div class="cur_contents">
                                            <ul>
                                                <li>
                                                    <ul>
                                                        <?php $__currentLoopData = $module->lectures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li
                                                            class="d-flex flex-row align-items-center justify-content-start">
                                                            <?php $filetype = explode(".", $lecture->slide); ?>
                                                            <?php if(end($filetype) == 'pdf'): ?>
                                                            <i class="fa fa-file" aria-hidden="true"></i>
                                                            <?php else: ?>
                                                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                                                            <?php endif; ?>
                                                            <span>
                                                                <a class="lecture_link"
                                                                    href="<?php echo e(route('lectures.show', ['id' => $lecture->id])); ?>">
                                                                    <?php echo e($lecture->name); ?>

                                                                </a>
                                                            </span>
                                                        </li>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Reviews -->
                        <div id="reviews" class="tab-pane tab_panel reviews fade">
                            <div class="panel_title">Đánh giá</div>
                            <div class="cur_reviews" style="margin-top:10px;">
                            </div>
                            <?php if($has_enrolled): ?>
                            <div class="review new-review">
                                <form method="POST" action="#" class="review-form">
                                    <?php echo csrf_field(); ?>

                                    <input type="hidden" name="course_id" value="<?php echo e($course->id); ?>">
                                    <input type="hidden" name="student_id"
                                        value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->student->id); ?>">
                                    <div class="form-group row">
                                        <textarea id="content"
                                            class="form-control <?php if ($errors->has('content')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('content'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="content"
                                            value="<?php echo e(old('content')); ?>" rows="3"></textarea>

                                        <span class="invalid-feedback content-error" role="alert"
                                            style="display: inline-block">
                                            <strong></strong>
                                        </span>
                                    </div>

                                    <div class="form-group pull-right">
                                        
                                        <button type="button" class="btn btn-primary e-btn review-submit">Lưu</button>
                                    </div>

                                    <div class="rating">
                                        <i class="fa fa-star" data-rate="1"></i>
                                        <i class="fa fa-star" data-rate="2"></i>
                                        <i class="fa fa-star" data-rate="3"></i>
                                        <i class="fa fa-star" data-rate="4"></i>
                                        <i class="fa fa-star" data-rate="5"></i>
                                        <input type="hidden" id="rating-count" name="rating" value="0">
                                        <span class="invalid-feedback rating-error" role="alert"
                                            style="display: inline">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="sidebar_background"></div>
                    <div class="sidebar_top">
                        <?php if($has_enrolled): ?>
                        <?php if(($module = $course->modules->first()) && $module->lectures->first()): ?>
                        <a style="background: gray"
                            href="<?php echo e(route('lectures.show', [$module->lectures->first()->id])); ?>">Continue</a>
                        <?php else: ?>
                        <a style="background: gray" href="<?php echo e(route('errors', [
                                                'error' => 'Lỗi nội dung khóa học',
                                                'message' => 'Khóa học bạn đang theo dõi chưa được thêm bài giảng',
                                            ])); ?>">
                            Tiếp tục</a>
                        <?php endif; ?>
                        <?php else: ?>
                        <a href="<?php echo e(route('courses.enroll', [$course->id])); ?>">
                            Đăng ký
                        </a>
                        <?php endif; ?>

                    </div>
                    <div class="sidebar_content">

                        <!-- Features -->
                        <div class="sidebar_section features">
                            <div class="sidebar_title">Thông tin thêm</div>
                            <div class="features_content">
                                <ul class="features_list">

                                    <!-- Feature -->
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-clock-o"
                                                aria-hidden="true"></i><span>Thời gian</span>
                                        </div>
                                        <div class="feature_text ml-auto"><?php echo e($course->duration->name); ?></div>
                                    </li>

                                    <!-- Feature -->
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-bell"
                                                aria-hidden="true"></i><span>Bài giảng</span>
                                        </div>
                                        <div class="feature_text ml-auto"><?php echo e(count($course->modules)); ?></div>
                                    </li>

                                    <!-- Feature -->
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-user"
                                                aria-hidden="true"></i><span>Lượt đăng ký</span>
                                        </div>
                                        <div class="feature_text ml-auto"><?php echo e(count($course->num_enrolls)); ?></div>
                                    </li>
                                    <li class="d-flex flex-row align-items-start justify-content-start">
                                        <div class="feature_title"><i class="fa fa-graduation-cap"
                                                aria-hidden="true"></i><span>Độ khó</span>
                                        </div>
                                        <?php $levels = [1 => 'Dễ', 2 => 'Trung bình', 3 => 'Khó']  ?>
                                        <div class="feature_text ml-auto"><?php echo e($levels[$course->level]); ?></div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- You may like -->
                        <div class="sidebar_section like">
                            <div class="sidebar_title">Có thể bạn thích</div>
                            <div class="like_items">
                                <?php $__currentLoopData = $recommend_courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r_c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <!-- Like Item -->
                                <div class="like_item d-flex flex-row align-items-end justify-content-start">
                                    <div class="like_title_container">
                                        <div class="like_title">
                                            <a href="<?php echo e(route('courses.show', ['id' => $r_c->id])); ?>" target="_blank"
                                                style="color: #000;"><?php echo e($r_c->name); ?></a>
                                        </div>
                                        <div class="like_subtitle"><?php echo e($r_c->teacher->user->name); ?></div>
                                    </div>
                                    <div class="like_price ml-auto">Free</div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // ------------------------------------------------------
        // ------------ Student update process course -----------
        <?php if(session('message')): ?>
        toastr.success("<?php echo e(session('message')); ?>");
        <?php endif; ?>

        var has_enrolled = <?php echo e(json_encode($has_enrolled)); ?>;
        function wanring_msg(selector, msg) {
            $(selector).click(function (e) {
                if (has_enrolled == false) {
                    e.preventDefault();
                    toastr.warning(msg);
                }
            });
        }
        wanring_msg('.lecture_link', 'Đăng ký tham gia khóa học trước khi truy cập bài giảng');
        wanring_msg('.process', 'Đăng ký tham gia khóa học trước khi cập nhật trạng thái');

        $('.process').click(function () {
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

        // ---------------------------------------------
        // ------------ Fetch student reviews -----------
        function fetch_reviews (url="<?php echo e(route('reviews.index', ['course_id' => $course->id])); ?>") {
            $.ajax({
                url: url,
                success: function (data) {
                    $('.cur_reviews').html(data.html);
                }
            });
        }

        $(document).ready(function () {
            fetch_reviews();

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                fetch_reviews(url=$(this).find("a").attr('href'));
            });
        });

        // ----------------------------------------------
        // ------------ Student rating course -----------
        $('.rating i')
            .on('click', function(){
                $('#rating-count').val($(this).data('rate'));
                $(this).parent().find('i:lt(' + ($(this).index() + 1) + ')').addClass('selected');
            })
            .on('mouseover', function(){
                    $(this).parent().children('.rating i').each(function(e){
                    $(this).removeClass('selected');
                });
                $(this).parent().find('i:lt(' + ($(this).index() + 1) + ')').addClass('hover');
            })
            .on('mouseout', function(){
                $(this).parent().children('.rating i').each(function(e){
                    $(this).removeClass('hover');
                });
            });

        $('.review-submit').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo e(route('reviews.store')); ?>",
                method: "POST",
                dataType: 'json',
                data: $('.review-form').serialize(),
                beforeSend: function () {
                    $('.review-form').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    toastr.success(data.message);
                    $('.review-form').waitMe('hide');
                    $('.review-form')[0].reset();
                    $('.rating i').removeClass('selected');
                    fetch_reviews();
                },
                error: function (reject) {
                    if( reject.status === 422 ) {
                        $('.review-form').waitMe('hide');
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function (key, val) {
                            $("." + key + "-error strong").text(val[0]);
                        });
                        toastr.error(errors.message);
                    }
                }
            });
        });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/course_details.blade.php ENDPATH**/ ?>