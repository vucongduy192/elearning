<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/blog_single.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/blog_single_responsive.css")); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding" style="height: 120px;"></div>

<div class="blog_top_image">
    <div class="blog_top">
        <div class="blog_background parallax-window" data-parallax="scroll"
             data-image-src="<?php echo e(asset($blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL)); ?>" data-speed="0.8"></div>
    </div>
</div>

<!-- Blog Content -->

<div class="blog_container">
    <div class="container">
        <div class="row blog_content_row">
            <div class="col">
                <div class="blog_content">
                    <div class="blog_post_title_container">
                        <div class="blog_title"><?php echo e($blog->title); ?></div>
                    </div>
                    <div class="blog_text">
                        <?php echo $blog->content; ?>

                    </div>
                    <div class="blog_post_footer d-flex flex-lg-row flex-column align-items-lg-center align-items-start justify-content-start">
                        <div class="blog_post_author d-flex flex-row align-items-center justify-content-start">
                            <div class="author_image"><div><img src="images/blog_author.jpg" alt=""></div></div>
                            <div class="author_info">
                                <ul>
                                    <li><?php echo e($blog->user->name); ?></li>
                                    <li><?php echo e(date('d/m/Y', strtotime($blog->created_at))); ?></li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog_post_share ml-lg-auto">
                            <span></span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Posts -->
        <h3 class="section_title" style="margin-top: 80px;">Newest post</h3> <br>
        <div class="row">
            <?php $__currentLoopData = $newest_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-6">
                    <div class="blog_post">
                        <div class="blog_image"
                             style="background-image: url('<?php echo e($blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL); ?>')"></div>
                        <div class="blog_title_container">
                            <div class="blog_post_title"><a href="<?php echo e(route('blogs.show', ['id' => $blog->id])); ?>"><?php echo e($blog->title); ?></a></div>
                            <div class="blog_post_text">
                                <p><?php echo e($blog->summary); ?></p>
                            </div>
                            <div class="read_more"><a href="<?php echo e(route('blogs.show', ['id' => $blog->id])); ?>">Read More <img src="<?php echo e(asset('front-end/images/right.png')); ?>" alt=""></a></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script src="<?php echo e(asset('front-end/plugins/parallax-js-master/parallax.min.js')); ?>"></script>
    <script src="<?php echo e(asset('front-end/js/blog_single.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/blog_details.blade.php ENDPATH**/ ?>