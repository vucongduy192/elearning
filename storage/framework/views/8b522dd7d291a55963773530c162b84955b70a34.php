<!DOCTYPE html>
<html lang="en">
<head>
    <title>E Learning</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Lingua project">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/bootstrap4/bootstrap.min.css")); ?>"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="<?php echo e(asset("front-end/plugins/font-awesome-4.7.0/css/font-awesome.min.css")); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/plugins/OwlCarousel2-2.2.1/owl.carousel.css")); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo e(asset("front-end/plugins/OwlCarousel2-2.2.1/owl.theme.default.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/plugins/OwlCarousel2-2.2.1/animate.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/plugins/toastr/toastr.min.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/plugins/waitMe/waitMe.min.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/custom.css")); ?>">
</head>
<body>
<?php echo $__env->yieldContent('styles'); ?>

<div class="super_container">
    <?php $__env->startComponent('components.header'); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- *** HEADER END *** -->

    <?php $__env->startComponent('components.navbar'); ?>
    <?php echo $__env->renderComponent(); ?>
    <!-- *** NAVBAR END *** -->

    <!-- *** CONTENT ***
    _________________________________________________________ -->
    <?php echo $__env->yieldContent('content'); ?>

    <!-- *** FOOTER ***
_________________________________________________________ -->
    <?php $__env->startComponent('components.footer'); ?>
    <?php echo $__env->renderComponent(); ?>
</div>
<!-- *** FOOTER END *** -->

<script src="<?php echo e(asset("front-end/js/jquery-3.2.1.min.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/styles/bootstrap4/popper.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/styles/bootstrap4/bootstrap.min.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/plugins/OwlCarousel2-2.2.1/owl.carousel.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/plugins/toastr/toastr.min.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/plugins/waitMe/waitMe.min.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/plugins/easing/easing.js")); ?>"></script>
<script src="<?php echo e(asset("front-end/js/custom.js")); ?>"></script>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/resources/views/layouts/master.blade.php ENDPATH**/ ?>