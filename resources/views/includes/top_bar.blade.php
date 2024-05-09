
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 logo">
                <img class="logodark" src="{{$setting->logo['path']}}" title="{{$setting->title}}" alt="{{$setting->title}}">
            </div>
            <div class="col-lg-6  col-md-9 mainmenu">
                <ul>
                    <li><a href="{{route('home')}}" class="current-menu-item">صفحه اصلی</a></li>
                    <li><a href="{{route('contact')}}">تماس با ما </a></li>
                    <li><a href="{{route('about')}}">درباره ما</a></li>
                </ul>
                <div class="menu-btn"><i class="agh-menu"></i></div>

            </div>
            <div class="col-lg-4  col-md-5 btnsc">
            <span class="loginregister">

                @if ($current_user || $current_carwash)

                    <div class="top_bar_profile">
                        <span><i class="fa-solid fa-user"></i></span>
                        <span>
                            @if ($current_carwash)
                                <a href="{{route('carwash_dashboard')}}">{{$current_carwash->title}}</a>
                                <span class="logout"><a href="{{route('logout')}}"><i
                                            class="fa-solid fa-right-from-bracket"></i> @lang('trs.logout')</a></span>

                            @else
                                <a href="{{route('user_show')}}">{{$current_user->fullName}}</a>
                                <span class="logout"><a href="{{route('logout')}}"><i
                                            class="fa-solid fa-right-from-bracket"></i> @lang('trs.logout')</a></span>

                            @endif
                        </span>
                    </div>
                @else

                    <a href="{{route('login','user')}}" class="login">ورود / ثبت نام</a>
                @endif
            </span>
                {{--                <span class="ams">--}}
                {{--              <span class="bgcolor"><button onClick="darkMode()"> <i class="agh-moon"></i> <i--}}
                {{--                          class="agh-sun"></i> </button></span>--}}
                {{--              <a href="#" class="download"><i class="agh-download"></i></a>--}}
                {{--             </span>--}}
            </div>
        </div>
    </div>
</header>
