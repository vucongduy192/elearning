<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/main_styles.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/responsive.css")); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding"></div>
<div class="auth">
    <div class="container">
        <div class="row auth_row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><?php echo e(__('Xác thực email')); ?></div>

                    <div class="card-body">
                        <?php if(session('resent')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(__('Mail xác thực đã được gửi đến địa chỉ mail của bạn')); ?>

                            </div>
                        <?php endif; ?>

                        <?php echo e(__('Trước khi bắt đầu, vui lòng kiểm tra email và xác thực')); ?>

                        <?php echo e(__('Nếu bạn không nhận được email')); ?>, <a href="<?php echo e(route('verification.resend')); ?>"><?php echo e(__('Bấm vào đây để gửi lại')); ?></a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/auth/verify.blade.php ENDPATH**/ ?>