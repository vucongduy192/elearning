<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/main_styles.css")); ?>">
<link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/responsive.css")); ?>">
<style>
    .carousel-item {
        min-height: 320px;
    }

    .carousel-control-next-icon:after {
        content: '>';
        font-size: 55px;
        color: rgba(0, 0, 0, 0.45);
    }

    .carousel-control-prev-icon:after {
        content: '<';
        font-size: 55px;
        color: rgba(0, 0, 0, 0.45);
    }

    .carousel-inner {
        width: 70%;
        margin-left: 15%;
    }

    ol.carousel-indicators li,
    ol.carousel-indicators li.active {
        border: 0;
        margin: 8px;
        height: 10px;
        width: 10px;
    }

    ol.carousel-indicators li {
        background: rgba(0, 0, 0, 0.45);
    }

    ol.carousel-indicators li.active {
        background: #2e21df;
    }

    .dot {
        position: absolute;
        transform: scale(1.5);
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding"></div>
<div class="auth">
    <div class="container">
        <div class="row auth_row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Khảo sát</div>

                    <div class="card-body">
                        <div id="survey-carousel" class="carousel slide" data-interval="false">
                            <ol class="carousel-indicators">
                                <li data-target="#survey-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#survey-carousel" data-slide-to="1"></li>
                                
                            </ol>
                            <div class="carousel-inner">
                                <form method="POST" action="<?php echo e(route('survey.update')); ?>" enctype="multipart/form-data"
                                    class="survey-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="level">Độ khó</label>
                                                <select class="form-control" name="level" id="">
                                                    <option value=""
                                                        <?php echo e(empty($surveyRank['ranks']->level) ? "selected" : ""); ?>>
                                                        Tất cả</option>
                                                    <option value="<?php echo e(App\Models\Course::EASY); ?>"
                                                        <?php echo e($surveyRank['ranks'] && $surveyRank['ranks']->level == 1 ? "selected" : ""); ?>>
                                                        Dễ</option>
                                                    <option value="<?php echo e(App\Models\Course::MEDIUM); ?>"
                                                        <?php echo e($surveyRank['ranks'] && $surveyRank['ranks']->level == 2 ? "selected" : ""); ?>>
                                                        Trung bình</option>
                                                    <option value="<?php echo e(App\Models\Course::HARD); ?>"
                                                        <?php echo e($surveyRank['ranks'] && $surveyRank['ranks']->level == 3 ? "selected" : ""); ?>>
                                                        Khó</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="duration_id">Thời gian</label>
                                                <select class="form-control" name="duration_id" id="">
                                                    <option value=""
                                                        <?php echo e(empty($surveyRank['ranks']->duration_id) ? "selected" : ""); ?>>
                                                        Tất cả
                                                    </option>
                                                    <?php $__currentLoopData = $surveyRank['durations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($duration->id); ?>"
                                                        <?php echo e($surveyRank['ranks'] && $duration->id == $surveyRank['ranks']->duration_id ? "selected" : ""); ?>>
                                                        <?php echo e($duration->name); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 20px;">
                                            <div class="col-sm-12">
                                                <label for="partner_id">From</label>
                                                <select class="form-control" name="partner_id" id="">
                                                    <option value=""
                                                        <?php echo e(empty($surveyRank['ranks']->partner_id) ? "selected" : ""); ?>>
                                                        Nguồn
                                                    </option>
                                                    <?php $__currentLoopData = $surveyRank['partners']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($partner->id); ?>"
                                                        <?php echo e($surveyRank['ranks'] && $partner->id == $surveyRank["ranks"]->partner_id ? "selected" : ""); ?>>
                                                        <?php echo e($partner->name); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="form-group template-checkbox col-md-6">
                                                <input type="checkbox" name="free" id="free"
                                                    <?php echo e($surveyRank["ranks"] && $surveyRank['ranks']->free == 1 ? "checked" : ""); ?>

                                                    value="1">
                                                <label for="free">Khóa học free</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            <?php $__currentLoopData = $survey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="form-group template-checkbox col-md-6">
                                                <input type="checkbox" name="category_id[]" id="<?php echo e($category->name); ?>"
                                                    <?php echo e($category->interest != null ? "checked" : ""); ?>

                                                    value="<?php echo e($category->id); ?>">
                                                <label for="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></label>
                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <?php if(session('message')): ?>
                                            <a href="<?php echo e(route('profile.recommend')); ?>" style="margin-left: 20px;">
                                                See your recommend now !</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary e-btn">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <a class="carousel-control-prev" href="#survey-carousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#survey-carousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
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
    <?php if(session('message')): ?>
        toastr.success("<?php echo e(session('message')); ?>");
        <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/survey.blade.php ENDPATH**/ ?>