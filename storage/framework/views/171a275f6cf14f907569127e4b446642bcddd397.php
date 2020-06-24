<header class="header">
    <?php if(strpos(Request::url(), 'lectures')): ?>
    <?php else: ?>
    <!-- Top Bar -->
    <div class="top_bar">
        <div class="top_bar_container">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
                            <div class="top_bar_phone"><span class="top_bar_title">SĐT:</span>0971053097</div>
                            <div class="top_bar_right ml-auto">

                                <!-- Social -->
                                <div class="top_bar_social">
                                    <span class="top_bar_title social_title">Mạng xã hội</span>
                                    <ul>
                                        <li><a
                                                href="https://www.facebook.com/H%E1%BB%8Dc-li%E1%BB%87u-tr%E1%BB%B1c-tuy%E1%BA%BFn-102682404824217/notifications/"><i
                                                    class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a
                                                href="https://www.facebook.com/H%E1%BB%8Dc-li%E1%BB%87u-tr%E1%BB%B1c-tuy%E1%BA%BFn-102682404824217/notifications/"><i
                                                    class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        <li><a
                                                href="https://www.facebook.com/H%E1%BB%8Dc-li%E1%BB%87u-tr%E1%BB%B1c-tuy%E1%BA%BFn-102682404824217/notifications/"><i
                                                    class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Header Content -->
    <div class="header_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justify-content-start">
                        <div class="logo_container mr-auto">
                            <a href="<?php echo e(route('home')); ?>">
                                <div class="logo_text">ELearn</div>
                            </a>
                        </div>

                        <nav class="main_nav_contaner">
                            <ul class="main_nav">
                                <li class="active">
                                    <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('courses.index')); ?>">Khóa học</a>
                                </li>
                                <li><a href="<?php echo e(route('professors.index')); ?>">Giảng viên</a>
                                </li>
                                <li><a href="<?php echo e(route('blogs.index')); ?>">Diễn đàn</a>
                                </li>
                                <?php if(auth()->guard()->guest()): ?>
                                <li>
                                    <a href="<?php echo e(route('login')); ?>">Đăng nhập</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('register')); ?>">Đăng ký</a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <div class="header_content_right ml-auto text-right">
                            <div class="header_search">
                                <div class="search_form_container">
                                    <form method="GET" action="<?php echo e(route('courses.index')); ?>"
                                        class="search_form trans_400">
                                        <?php echo csrf_field(); ?>
                                        <input type="search" class="header_search_input trans_400"
                                            placeholder="Type for Search" name="name">
                                        <div class="search_button">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="hamburger menu_mm">
                                <i class="fa fa-bars menu_mm" aria-hidden="true"></i>
                            </div>

                            <?php if(auth()->guard()->guest()): ?>
                            <?php else: ?>
                            <div class="user">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

                                                <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
                                               <img style="height: 40px; width: 40px; margin-top: -10px; border-radius: 50%;"
                                                    src="<?php echo e($user->avatar ? $user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR); ?>"/>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                                                Hồ sơ
                                            </a>
                                            <?php if($user->role_id == \App\Models\User::STUDENT): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('profile.enrolled_page')); ?>">
                                                Lịch sử học
                                            </a>
                                            <a class="dropdown-item" href="<?php echo e(route('profile.recommend')); ?>">
                                                Gợi ý
                                            </a>
                                            <?php elseif($user->role_id == \App\Models\User::TEACHER): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('admin')); ?>">
                                                Quản lý khóa học
                                            </a>
                                            <?php endif; ?>

                                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                Đăng xuất
                                            </a>

                                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                                style="display: none;">
                                                <?php echo csrf_field(); ?>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /var/www/resources/views/components/header.blade.php ENDPATH**/ ?>