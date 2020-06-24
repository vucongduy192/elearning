<div class="row blog_row">
    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-lg-6">
            <div class="blog_post">
                <div class="blog_image"
                     style="background-image: url('<?php echo e($blog->thumbnail ? $blog->thumbnail : \App\Models\Config::PLACEHOLDER_THUMBNAIL); ?>')"></div>
                <div class="blog_title_container">
                    <div class="blog_post_title"><a href="<?php echo e(route('blogs.show', ['id' => $blog->id])); ?>"><?php echo e(substr($blog->title, 0, 20).'...'); ?></a></div>
                    <div class="blog_post_text">
                        <p><?php echo e($blog->summary); ?></p>
                    </div>
                    <div class="read_more"><a href="<?php echo e(route('blogs.show', ['id' => $blog->id])); ?>">Xem thêm <img src="<?php echo e(asset('front-end/images/right.png')); ?>" alt=""></a></div>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="pull-right">
    <?php echo e($blogs->links('components.pagination')); ?>

</div>
<?php /**PATH /var/www/resources/views/components/blogs_list.blade.php ENDPATH**/ ?>