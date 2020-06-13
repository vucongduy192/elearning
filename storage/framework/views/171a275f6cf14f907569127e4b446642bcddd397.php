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
                            <div class="top_bar_phone"><span class="top_bar_title">phone:</span>+44 300 303 0266</div>
                            <div class="top_bar_right ml-auto">

                                <!-- Social -->
                                <div class="top_bar_social">
                                    <span class="top_bar_title social_title">follow us</span>
                                    <ul>
                                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
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
                                    <a href="<?php echo e(route('home')); ?>">Home</a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('courses.index')); ?>">Courses</a>
                                </li>
                                <li><a href="<?php echo e(route('professors.index')); ?>">Professors</a>
                                </li>
                                <li><a href="<?php echo e(route('blogs.index')); ?>">Blogs</a>
                                </li>
                                <?php if(auth()->guard()->guest()): ?>
                                <li>
                                    <a href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <div class="header_content_right ml-auto text-right">
                            <div class="header_search">
                                <div class="search_form_container">
                                    <form method="POST" action="<?php echo e(route('courses.search')); ?>"
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
                                            <i class="fa fa-user"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                                                Profile
                                            </a>
                                            <?php if(\Illuminate\Support\Facades\Auth::user()->role_id == \App\Models\User::STUDENT): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('profile.enrolled_page')); ?>">
                                                My Courses
                                            </a>
                                            <a class="dropdown-item" href="<?php echo e(route('profile.recommend')); ?>">
                                                Recommend
                                            </a>
                                            <?php elseif(\Illuminate\Support\Facades\Auth::user()->role_id == \App\Models\User::TEACHER): ?>
                                            <a class="dropdown-item" href="<?php echo e(route('admin')); ?>">
                                                Courses Manager
                                            </a>
                                            <?php endif; ?>

                                            <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                <?php echo e(__('Logout')); ?>

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