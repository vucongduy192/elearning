<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/courses.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/courses_responsive.css")); ?>">
    <style>
        .header_padding {
            height: 130px;
        }
        .form-search .form-group {
            margin-bottom: 0px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="header_padding"></div>
    <div class="courses" style="min-height: 700px;">
        <div class="container">
            <div class="card" style="margin-bottom: 20px;">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('courses.search')); ?>" class="search-form">
                        <?php echo csrf_field(); ?>
                        <div class="row" style="margin-bottom: -20px;">
                            <div class="col-md-5 form-group">
                                <input id="name" type="text" value="<?php echo e($header_search_name); ?>" class="form-control" name="name" placeholder="Khóa học">
                            </div>

                            <div class="col-md-3 form-group">
                                <input id="teacher" type="text" class="form-control" name="teacher" placeholder="Giảng viên">
                            </div>

                            <div class="col-md-3 form-group">
                                <select class="form-control" name="courses_category_id" id="">
                                    <option value="" <?php echo e(!old('courses_category_id') ? "selected" : ""); ?>>Tất cả </option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($c->id); ?>" <?php echo e(old('courses_category_id') == $c->id ? "selected" : ""); ?>><?php echo e($c->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary e-btn search-btn">
                                    Tìm kiếm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="courses_list" style="min-height: 295px;">

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function filter_courses(url="<?php echo e(route('courses.search')); ?>") {
            $.ajax({
                url: url,
                method: "POST",
                dataType: 'json',
                data: $('.search-form').serialize(),
                beforeSend: function () {
                    $('.courses_list').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    $('.courses_list').waitMe('hide').html(data.html);
                }
            });
        }
        $(document).ready(function () {
            filter_courses();

            $('.search-btn').click(function (e) {
                e.preventDefault();
                filter_courses();
            });

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                filter_courses(url=$(this).find("a").attr('href'));
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/courses.blade.php ENDPATH**/ ?>