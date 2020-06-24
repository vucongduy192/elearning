<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/blog.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/blog_responsive.css")); ?>">
    <style>
        .blog_row {
            margin-top: 30px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding"></div>
<div class="blog">
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="section_title text-center">Diễn đàn</h2>
            </div>
        </div>

        <div class="blogs_list" style="min-height: 350px;">

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function fetch_blogs(url="<?php echo e(route('blogs.search')); ?>") {
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                },
                beforeSend: function () {
                    $('.blogs_list').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    $('.blogs_list').waitMe('hide').html(data.html);
                }
            });
        }
        $(document).ready(function () {
            fetch_blogs();

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                fetch_blogs(url=$(this).find("a").attr('href'));
            });
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/blogs.blade.php ENDPATH**/ ?>