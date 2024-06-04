<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brands demo">
        <a href="{{route('home')}}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold ms-2"> <img src="{{$setting->logo['path']}}"
                                                                           style="width:80px;"></span>
        </a>


    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner">
        <!-- Dashboards -->
        <li class="menu-item {{url()->current()==route('carwash_dashboard') ? 'active' : ''}}">
            <a href="{{route('carwash_dashboard')}}" class="menu-link">
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Dashboards">@lang('trs.dashboard')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('carwash_services') || url()->current()==route('carwash_service_create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-hands-bubbles"></i>
                <div data-i18n="Layouts">@lang('trs.services')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('carwash_service_create') }}" class="menu-link">
                        <i class="fa-solid fa-heart-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_service')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('carwash_services')}}" class="menu-link">
                        <i class="menu-icon fa-solid fa-list"></i>
                        <div data-i18n="Vertical">@lang('trs.services_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        product--}}
        <li class="menu-item {{url()->current()==route('carwash_product_create') || url()->current()==route('carwash_products') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-cart-shopping"></i>
                <div data-i18n="Layouts">@lang('trs.products')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('carwash_product_create') }}" class="menu-link">
                        <i class="fa-solid fa-cart-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_new_product')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('carwash_products')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.products_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        product--}}

        <li class="menu-item {{url()->current()==route('carwash_reservations') ? 'active' : ''}}">
            <a href="{{route('carwash_reservations')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-list"></i>
                <div data-i18n="Dashboards">@lang('trs.reservations')</div>
            </a>
        </li>

        <!-- Support -->
        <li class="menu-item {{url()->current()==route('carwash_ticket_create') || url()->current()==route('carwash_tickets') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Layouts">تیکت پشتیبانی</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('carwash_ticket_create') }}" class="menu-link">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                        <div data-i18n="Without menu">ارسال تیکت</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('carwash_tickets')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">لیست تیکت ها</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Support -->


        {{-- blog --}}
        {{--        <li class="menu-item {{url()->current()==route('carwash_blog_create') || url()->current()==route('carwash_blogs') ? 'active' : ''}}">--}}
        {{--            <a href="javascript:void(0)" class="menu-link menu-toggle">--}}
        {{--                <i class="menu-icon fa-solid fa-blog"></i>--}}
        {{--                <div data-i18n="Layouts">بلاگ</div>--}}
        {{--            </a>--}}

        {{--            <ul class="menu-sub">--}}
        {{--                <li class="menu-item">--}}
        {{--                    <a href="{{ route('carwash_blog_create') }}" class="menu-link">--}}
        {{--                        <i class="fa-solid fa-circle-plus"></i>--}}
        {{--                        <div data-i18n="Without menu">پست جدید</div>--}}
        {{--                    </a>--}}
        {{--                </li>--}}
        {{--                <li class="menu-item">--}}
        {{--                    <a href="{{route('carwash_blogs')}}" class="menu-link">--}}
        {{--                        <i class="fa-solid fa-rectangle-list"></i>--}}
        {{--                        <div data-i18n="Vertical">لیست پست ها</div>--}}
        {{--                    </a>--}}
        {{--                </li>--}}
        {{--            </ul>--}}
        {{--        </li>--}}
        {{-- blog --}}


        {{-- bank --}}
        <li class="menu-item {{url()->current()==route('carwash_bank_create') || url()->current()==route('carwash_banks') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-building-columns"></i>
                <div data-i18n="Layouts">بانک ها</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('carwash_bank_create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">کارت جدید</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('carwash_banks')}}" class="menu-link">
                        <i class="fa-solid fa-credit-card"></i>
                        <div data-i18n="Vertical">@lang('trs.bank_cards_list')</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- bank --}}


        {{--        payment--}}
        <li class="menu-item {{url()->current()==route('carwash_incomes') || url()->current()==route('carwash_withdraw_create') || url()->current()==route('carwash_withdraws') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-money-bill"></i>
                <div data-i18n="Layouts">مالی</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('carwash_incomes') }}" class="menu-link">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        <div data-i18n="Without menu">لیست درامد ها</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('carwash_withdraws')}}" class="menu-link">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <div data-i18n="Vertical">لیست برداشت ها</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('carwash_withdraw_create')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">@lang('trs.new_withdraw')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        payment--}}


        {{-- time --}}
        <li class="menu-item {{url()->current()==route('carwash_times') || url()->current()==route('carwash_timetable') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-regular fa-clock"></i>
                <div data-i18n="Layouts">@lang('trs.times_table')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('carwash_times') }}" class="menu-link">
                        <i class="fa-solid fa-business-time"></i>
                        <div data-i18n="Without menu">@lang('trs.week_times')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('carwash_timetable') }}" class="menu-link">
                        <i class="fa-solid fa-calendar-days"></i>
                        <div data-i18n="Without menu">@lang('trs.times_table')</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- time --}}

        {{--        users--}}
        <li class="menu-item {{url()->current()==route('carwash_users') ? 'active' : ''}}">
            <a href="{{route('carwash_users')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-list"></i>
                <div data-i18n="Dashboards">@lang('trs.users')</div>
            </a>
        </li>
        {{--        users--}}


        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link">
                <i class="menu-icon agh-logout"></i>
                <div data-i18n="Dashboards">خروج</div>
            </a>
        </li>
    </ul>
</aside>
