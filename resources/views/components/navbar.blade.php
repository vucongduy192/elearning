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
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="menu_mm">
                <a href="{{ route('courses.index') }}">Courses</a>
            </li>
            <li class="menu_mm"><a href="{{ route('professors.index') }}">Professors</a>
            </li>
            @guest
            <li class="menu_mm">
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            <li class="menu_mm">
                <a href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @else
            <li class="menu_mm">
                <a href="{{ route('profile.show') }}">Profile</a>
            </li>
            @if(\Illuminate\Support\Facades\Auth::user()->role_id == \App\Models\User::STUDENT)
            <li class="menu_mm">
                <a href="{{ route('profile.enrolled_page') }}">My Courses</a>
            </li>
            <li class="menu_mm">
                <a href="{{ route('profile.recommend') }}">Recommend</a>
            </li>
            @elseif(\Illuminate\Support\Facades\Auth::user()->role_id == \App\Models\User::TEACHER)
            <li class="menu_mm">
                <a href="{{ route('admin') }}">Courses Manager</a>
            </li>
            @endif
            <li class="menu_mm">
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
            </li>
            @endguest
        </ul>
    </nav>
    <div class="menu_extra">
        <div class="menu_phone"><span class="menu_title">phone:</span>+44 300 303 0266</div>
        <div class="menu_social">
            <span class="menu_title">follow us</span>
            <ul>
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</div>