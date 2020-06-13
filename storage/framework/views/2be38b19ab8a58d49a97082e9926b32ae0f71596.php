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
                        <div class="card-header"><?php echo e($error); ?></div>
                        
                        <div class="card-body">
                            <?php echo $message; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/errors.blade.php ENDPATH**/ ?>