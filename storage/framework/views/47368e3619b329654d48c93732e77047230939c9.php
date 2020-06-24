<!-- Menu -->
<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    <div class="menu_close_container">
        <div class="menu_close">
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="search">
        <form action="#" class="header_search_form menu_mm">
            <input type="search" class="search_input menu_mm" placeholder="Search" required="required">
            <button class="header_search_button d-flex flex-column align-items-center justify-content-center menu_mm">
                <i class="fa fa-search menu_mm" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <nav class="menu_nav">
        <ul class="menu_mm">
            <li class="menu_mm">
                <a href="<?php echo e(route('home')); ?>">Trang chủ</a>
            </li>
            <li class="menu_mm">
                <a href="<?php echo e(route('courses.index')); ?>">Khóa học</a>
            </li>
            <li class="menu_mm"><a href="<?php echo e(route('professors.index')); ?>">Giảng viên</a>
            </li>
            <?php if(auth()->guard()->guest()): ?>
            <li class="menu_mm">
                <a href="<?php echo e(route('login')); ?>">Đăng nhập</a>
            </li>
            <li class="menu_mm">
                <a href="<?php echo e(route('register')); ?>">Đăng xuất</a>
            </li>
            <?php else: ?>
            <li class="menu_mm">
                <a href="<?php echo e(route('profile.show')); ?>">Hồ sơ</a>
            </li>
            <?php if(\Illuminate\Support\Facades\Auth::user()->role_id == \App\Models\User::STUDENT): ?>
            <li class="menu_mm">
                <a href="<?php echo e(route('profile.enrolled_page')); ?>">Lịch sử học</a>
            </li>
            <li class="menu_mm">
                <a href="<?php echo e(route('profile.recommend')); ?>">Gợi ý</a>
            </li>
            <?php elseif(\Illuminate\Support\Facades\Auth::user()->role_id == \App\Models\User::TEACHER): ?>
            <li class="menu_mm">
                <a href="<?php echo e(route('admin')); ?>">Quản lý khóa học</a>
            </li>
            <?php endif; ?>
            <li class="menu_mm">
                <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                    Đăng xuất
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="menu_extra">
        <div class="menu_phone"><span class="menu_title">SĐT:</span>0971053097</div>
        <div class="menu_social">
            <span class="menu_title">Mạng xã hội</span>
            <ul>
                <li><a href="https://www.facebook.com/H%E1%BB%8Dc-li%E1%BB%87u-tr%E1%BB%B1c-tuy%E1%BA%BFn-102682404824217/notifications/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="https://www.facebook.com/H%E1%BB%8Dc-li%E1%BB%87u-tr%E1%BB%B1c-tuy%E1%BA%BFn-102682404824217/notifications/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="https://www.facebook.com/H%E1%BB%8Dc-li%E1%BB%87u-tr%E1%BB%B1c-tuy%E1%BA%BFn-102682404824217/notifications/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH /var/www/resources/views/components/navbar.blade.php ENDPATH**/ ?>