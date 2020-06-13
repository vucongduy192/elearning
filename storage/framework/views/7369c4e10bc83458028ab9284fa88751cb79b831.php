<?php $__env->startSection('styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/courses.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/courses_responsive.css")); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/instructors.css")); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("front-end/styles/instructors_responsive.css")); ?>">
    <style>
        .instructors_background {
            top: 30px;
        }
        .courses {
            background: white;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="header_padding" style="height: 120px;"></div>
    <div class="instructors">
        <div class="instructors_background"
             style="background-image: url(<?php echo e(asset('front-end/images/instructors_background.png')); ?>)"></div>
        <div class="container">
            <div class="row instructors_row">
                <div class="col-lg-4 instructor_col">
                    <div class="instructor text-center">
                        <div class="instructor_image_container">
                            <div class="instructor_image"><img
                                    src="<?php echo e(asset($professor->user->avatar ? $professor->user->avatar
                                                                           : \App\Models\Config::PLACEHOLDER_AVATAR)); ?>"
                                    alt=""></div>
                        </div>
                        <div class="instructor_name"><a href="#"><?php echo e($professor->user->name); ?></a></div>
                        <div class="instructor_social">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="professor_detail">
                        <div class="instructor_name"><a href="#">Information</a></div>
                        <div class="instructor_text">
                            <p>In 2011, he led the development of Stanford University’s main MOOC (Massive Open Online Courses) platform and also taught an online Machine Learning class to over 100,000 students, thus helping launch the MOOC movement and also leading to the founding of Coursera.</p>
                            <p>Ng also works on machine learning, with an emphasis on deep learning. He had founded and led the “Google Brain” project, which developed massive-scale deep learning algorithms. This resulted in the famous “Google cat” result, in which a massive neural network with 1 billion parameters learned from unlabeled YouTube videos to detect cats. Until recently, he led Baidu's ~1300 person AI Group, which developed technologies in deep learning, speech, computer vision, NLP, and other areas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="courses">
        <div class="container">
            <h3 class="section_title">Courses</h3>
            <div class="professor_courses_list courses_list"></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        var professor_id = "<?php echo e($professor->id); ?>";
        function professor_courses(url="<?php echo e(route('professors.professor_courses')); ?>") {
            $.ajax({
                url: url,
                method: "POST",
                data: {
                    _token: "<?php echo e(csrf_token()); ?>",
                    professor_id: professor_id,
                },
                beforeSend: function () {
                    $('.professor_courses_list').waitMe({effect: 'bounce', text: '', bg: 'rgba(255,255,255,0.7)', color: '#000'});
                },
                success: function (data) {
                    $('.professor_courses_list').waitMe('hide').html(data.html);
                }
            });
        }
        $(document).ready(function () {
            professor_courses();

            $('body').on('click', '.pagination li',  function (e) {
                e.preventDefault();
                professor_courses(url=$(this).find("a").attr('href'));
            });
        })
    </script>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/pages/professor_details.blade.php ENDPATH**/ ?>