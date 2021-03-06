<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/main_styles.css")); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/responsive.css")); ?>">
<style>
    .tabs {
        background: #f1f1f1;
    }

    .tabs {
        margin-bottom: 20px;
    }

    .tabs .nav-link {
        line-height: 40px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding" style="height: 120px;"></div>
<div class="auth" style="min-height: 650px;">
    <div class="container">
        <div class="col-md-8 offset-md-2">
            <div class="tab_panels">
                <!-- Tabs -->
                <div class="tabs nav nav-tabs d-flex flex-row align-items-center justify-content-start" role="tablist">
                    <a class="nav-link process-type active" data-toggle="tab" href="#process">Đang học dở</a>
                    <a class="nav-link process-type" data-toggle="tab" href="#completed">Hoàn thành</a>
                </div>

                <div class="tab-content">
                    <div id="process" class="tab-pane tab_panel active">
                    </div>

                    <div id="completed" class="tab-pane tab_panel">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    var completed = 0;
        function filter_enrolled_courses(url="<?php echo e(route('profile.enrolled_courses')); ?>") {
            var tab = (completed === 0) ? $('#process') : $('#completed');
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    completed: completed
                },
                beforeSend: function () {
                    tab.waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    tab.waitMe('hide').html(data.html);
                }
            });
        }
        $(document).ready(function () {
            filter_enrolled_courses();

            $('.process-type').click(function (e) {
                completed = ($(this).attr('href') === '#completed') ? 1 : 0;
                e.preventDefault();
                filter_enrolled_courses(undefined, completed);
            });

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                filter_enrolled_courses(url=$(this).find("a").attr('href'));
            });
        })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/enrolled_courses.blade.php ENDPATH**/ ?>