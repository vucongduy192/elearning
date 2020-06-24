<header class="header">
    @if (strpos(Request::url(), 'lectures'))
    @else
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
    @endif
    <!-- Header Content -->
    <div class="header_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justify-content-start">
                        <div class="logo_container mr-auto">
                            <a href="{{ route('home') }}">
                                <div class="logo_text">ELearn</div>
                            </a>
                        </div>

                        <nav class="main_nav_contaner">
                            <ul class="main_nav">
                                <li class="active">
                                    <a href="{{ route('home') }}">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ route('courses.index') }}">Khóa học</a>
                                </li>
                                <li><a href="{{ route('professors.index') }}">Giảng viên</a>
                                </li>
                                <li><a href="{{ route('blogs.index') }}">Diễn đàn</a>
                                </li>
                                @guest
                                <li>
                                    <a href="{{ route('login') }}">Đăng nhập</a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}">Đăng ký</a>
                                </li>
                                @endguest
                            </ul>
                        </nav>
                        <div class="header_content_right ml-auto text-right">
                            <div class="header_search">
                                <div class="search_form_container">
                                    <form method="GET" action="{{ route('courses.index') }}"
                                        class="search_form trans_400">
                                        @csrf
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

                            @guest
                            @else
                            <div class="user">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
{{--                                            <i class="fa fa-user"></i>--}}
                                                <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
                                               <img style="height: 40px; width: 40px; margin-top: -10px; border-radius: 50%;"
                                                    src="{{ $user->avatar ? $user->avatar : \App\Models\Config::PLACEHOLDER_AVATAR }}"/>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                                Hồ sơ
                                            </a>
                                            @if($user->role_id == \App\Models\User::STUDENT)
                                            <a class="dropdown-item" href="{{ route('profile.enrolled_page') }}">
                                                Lịch sử học
                                            </a>
                                            <a class="dropdown-item" href="{{ route('profile.recommend') }}">
                                                Gợi ý
                                            </a>
                                            @elseif($user->role_id == \App\Models\User::TEACHER)
                                            <a class="dropdown-item" href="{{ route('admin') }}">
                                                Quản lý khóa học
                                            </a>
                                            @endif

                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                                Đăng xuất
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
