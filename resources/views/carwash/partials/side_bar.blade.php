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
        <li class="menu-item {{url()->current()==route('servant_dashboard') ? 'active' : ''}}">
            <a href="{{route('servant_dashboard')}}" class="menu-link">
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Dashboards">@lang('trs.dashboard')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('servant_services') || url()->current()==route('servant_service_create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-list"></i>
                <div data-i18n="Layouts">@lang('trs.services')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_service_create') }}" class="menu-link">
                        <i class="menu-icon fa-solid fa-list"></i>
                        <div data-i18n="Without menu">@lang('trs.add_service')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_services')}}" class="menu-link">
                        <i class="menu-icon fa-solid fa-list"></i>
                        <div data-i18n="Vertical">@lang('trs.services_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        product--}}
        <li class="menu-item {{url()->current()==route('servant_product_create') || url()->current()==route('servant_products') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Layouts">@lang('trs.products')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_product_create') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">@lang('trs.add_new_product')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_products')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">@lang('trs.products_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        product--}}

        <li class="menu-item {{url()->current()==route('servant_reservations') ? 'active' : ''}}">
            <a href="{{route('servant_reservations')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-list"></i>
                <div data-i18n="Dashboards">@lang('trs.reservations')</div>
            </a>
        </li>

        <!-- Support -->
        <li class="menu-item {{url()->current()==route('servant_ticket_create') || url()->current()==route('servant_tickets') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Layouts">تیکت پشتیبانی</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_ticket_create') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">ارسال تیکت</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_tickets')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">لیست تیکت ها</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Support -->

        <!-- subs -->
        <li class="menu-item {{url()->current()==route('servant_requested_subs') || url()->current()==route('servant_sub_create') || url()->current()==route('servant_subs') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Layouts">@lang("trs.subs")</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_sub_create') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">@lang("trs.new_sub")</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_requested_subs')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">@lang("trs.requested_list")</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_subs')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">@lang("trs.subs_list")</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- subs -->

        {{--        parents--}}
        <li class="menu-item {{url()->current()==route('servant_parent_create') || url()->current()==route('servant_requested_parents') || url()->current()==route('servant_parents') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Layouts">@lang("trs.parents")</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_parent_create') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">@lang("trs.new_parent")</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('servant_requested_parents') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">@lang("trs.requested_parents")</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_parents')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">@lang("trs.parents_list")</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        parents--}}

        {{-- blog --}}
        <li class="menu-item {{url()->current()==route('servant_blog_create') || url()->current()==route('servant_blogs') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-blog"></i>
                <div data-i18n="Layouts">بلاگ</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_blog_create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">پست جدید</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_blogs')}}" class="menu-link">
                        <i class="fa-solid fa-rectangle-list"></i>
                        <div data-i18n="Vertical">لیست پست ها</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- blog --}}


        {{-- bank --}}
        <li class="menu-item {{url()->current()==route('servant_bank_create') || url()->current()==route('servant_banks') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-building-columns"></i>
                <div data-i18n="Layouts">بانک ها</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_bank_create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">کارت جدید</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_banks')}}" class="menu-link">
                        <i class="fa-solid fa-credit-card"></i>
                        <div data-i18n="Vertical">@lang('trs.bank_cards_list')</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- bank --}}

        {{-- address --}}
        <li class="menu-item {{url()->current()==route('servant_address_create') || url()->current()==route('servant_addresses') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-building-columns"></i>
                <div data-i18n="Layouts">@lang('trs.addresses')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_address_create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.new_address')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_addresses')}}" class="menu-link">
                        <i class="fa-solid fa-credit-card"></i>
                        <div data-i18n="Vertical">@lang('trs.addresses_list')</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- address --}}

        {{--        payment--}}
        <li class="menu-item {{url()->current()==route('servant_incomes') || url()->current()==route('servant_withdraw_create') || url()->current()==route('servant_withdraws') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Layouts">مالی</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_incomes') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">لیست درامد ها</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_withdraws')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">لیست برداشت ها</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('servant_withdraw_create')}}" class="menu-link">
                        <i class="fa-solid fa-envelope"></i>
                        <div data-i18n="Vertical">@lang('trs.new_withdraw')</div>
                    </a>
                </li>
            </ul>
        </li>

        {{--        payment--}}


        {{-- time --}}
        <li class="menu-item {{url()->current()==route('servant_times') || url()->current()==route('servant_timetable') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-building-columns"></i>
                <div data-i18n="Layouts">@lang('trs.times_table')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('servant_times') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.week_times')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('servant_timetable') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.times_table')</div>
                    </a>
                </li>
            </ul>
        </li>
        {{-- time --}}


        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link">
                <i class="menu-icon agh-logout"></i>
                <div data-i18n="Dashboards">خروج</div>
            </a>
        </li>
    </ul>
</aside>
