<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/main_styles.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/responsive.css")); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="header_padding" style="height: 120px;"></div>
<div class="auth">
    <div class="container">
        <div class="row auth_row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Hồ sơ</div>

                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="id" value="<?php echo e($user->id); ?>">

                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" name="email" disabled class="form-control"
                                        value="<?php echo e($user->email); ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="first_name" class="col-md-2 col-form-label text-md-right">First name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control <?php if ($errors->has('first_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('first_name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="first_name"
                                        value="<?php echo e(old('first_name') ? old('first_name') : $user->first_name); ?>">

                                    <?php if ($errors->has('first_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('first_name'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-2 col-form-label text-md-right">Last name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control <?php if ($errors->has('last_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('last_name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="last_name"
                                        value="<?php echo e(old('last_name') ? old('last_name') : $user->last_name); ?>">

                                    <?php if ($errors->has('last_name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('last_name'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="last_name" class="col-md-2 col-form-label text-md-right">Ảnh đại diện</label>

                                <div class="col-md-6">
                                    <input type="file" id="avatar" name="avatar"
                                        class="form-control preview-upload-image" />
                                    <img src="<?php echo e($user->avatar ? $user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR); ?>"
                                        class="preview-avatar" />
                                </div>
                            </div>
                            <?php if($user->role_id == \App\Models\User::STUDENT): ?>
                            <div class="form-group row">
                                <label for="school" class="col-md-2 col-form-label text-md-right">School</label>

                                <div class="col-md-6">
                                    <input id="school" type="text"
                                        class="form-control <?php if ($errors->has('school')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('school'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="school"
                                        value="<?php echo e(old('school') ? old('school') : $user->student->school); ?>">

                                    <?php if ($errors->has('school')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('school'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="school" class="col-md-2 col-form-label text-md-right">Major</label>

                                <div class="col-md-6">
                                    <input id="major" type="text"
                                        class="form-control <?php if ($errors->has('major')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('major'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="major"
                                        value="<?php echo e(old('major') ? old('major') : $user->student->major); ?>">

                                    <?php if ($errors->has('major')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('major'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>
                            <?php elseif($user->role_id == \App\Models\User::TEACHER): ?>
                            <div class="form-group row">
                                <label for="expert" class="col-md-2 col-form-label text-md-right">Expert</label>

                                <div class="col-md-6">
                                    <input id="expert" type="text"
                                        class="form-control <?php if ($errors->has('expert')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('expert'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="expert"
                                        value="<?php echo e(old('expert') ? old('expert') : $user->teacher->expert); ?>">

                                    <?php if ($errors->has('expert')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('expert'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="expert" class="col-md-2 col-form-label text-md-right">Workplace</label>

                                <div class="col-md-6">
                                    <input id="workplace" type="text"
                                        class="form-control <?php if ($errors->has('expert')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('expert'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="workplace"
                                        value="<?php echo e(old('workplace') ? old('workplace') : $user->teacher->workplace); ?>">

                                    <?php if ($errors->has('workplace')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('workplace'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                    <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-2">
                                    Cập nhật sở thích của bạn. Làm <a href="<?php echo e(route('survey.show')); ?>"> khảo sát </a> ngay.
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-2">
                                    <button type="submit" class="btn btn-primary e-btn">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.preview-avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }

    $("#avatar").change(function() {
        readURL(this);
    });

    <?php if(session('message')): ?>
        toastr.success("<?php echo e(session('message')); ?>");
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/profile.blade.php ENDPATH**/ ?>