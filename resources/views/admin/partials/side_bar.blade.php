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
        <li class="menu-item {{url()->current()==route('admin.dashboard') ? 'active' : ''}}">
            <a href="{{route('admin.dashboard')}}" class="menu-link">
                <i class="menu-icon fa-solid fa-house"></i>
                <div data-i18n="Dashboards">@lang('trs.dashboard')</div>
            </a>
        </li>


        <li class="menu-item {{url()->current()==route('admin.users') ? 'active' : ''}}">
            <a href="{{route('admin.users')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-users"></i>
                <div data-i18n="Dashboards">@lang('trs.users')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('admin.carwashes') ? 'active' : ''}}">
            <a href="{{route('admin.carwashes')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-car-tunnel"></i>
                <div data-i18n="Dashboards">@lang('trs.carwashes')</div>
            </a>
        </li>


        <li class="menu-item {{url()->current()==route('admin.services') ? 'active' : ''}}">
            <a href="{{route('admin.services')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-hands-bubbles"></i>
                <div data-i18n="Dashboards">@lang('trs.services')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('admin.products') ? 'active' : ''}}">
            <a href="{{route('admin.products')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-basket-shopping"></i>
                <div data-i18n="Dashboards">@lang('trs.products')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('admin.reservations') ? 'active' : ''}}">
            <a href="{{route('admin.reservations')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-list"></i>
                <div data-i18n="Dashboards">@lang('trs.reservations')</div>
            </a>
        </li>


        <li class="menu-item {{url()->current()==route('admin.payments') || url()->current()==route('admin.releases') || url()->current()==route('admin.deposits') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-money-bill"></i>
                <div data-i18n="Layouts">@lang('trs.financial')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.payments') }}" class="menu-link">
                        <i class="fa-regular fa-envelope"></i>
                        <div data-i18n="Without menu">@lang('trs.payments')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.releases')}}" class="menu-link">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        <div data-i18n="Vertical">@lang('trs.releases')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.deposits')}}" class="menu-link">
                        <i class="fa-solid fa-money-bill-transfer"></i>
                        <div data-i18n="Vertical">@lang('trs.withdraws')</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{url()->current()==route('admin.tickets','user') ? 'active' : ''}}">
            <a href="{{route('admin.tickets','user')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Dashboards">@lang('trs.user_ticket')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('admin.tickets','carwash') ? 'active' : ''}}">
            <a href="{{route('admin.tickets','carwash')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-headset"></i>
                <div data-i18n="Dashboards">@lang('trs.carwash_ticket')</div>
            </a>
        </li>

        <li class="menu-item {{url()->current()==route('admin.categories') || url()->current()==route('admin.category.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-layer-group"></i>
                <div data-i18n="Layouts">@lang('trs.categories')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.category.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_category')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.categories')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.categories_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{url()->current()==route('admin.types') || url()->current()==route('admin.type.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-layer-group"></i>
                <div data-i18n="Layouts">@lang('trs.types')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.type.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_type')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.types')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.types_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{url()->current()==route('admin.brands') || url()->current()==route('admin.brand.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-layer-group"></i>
                <div data-i18n="Layouts">@lang('trs.brands')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.brand.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_brand')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.brands')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.brands_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{url()->current()==route('admin.models') || url()->current()==route('admin.model.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-layer-group"></i>
                <div data-i18n="Layouts">@lang('trs.models')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.model.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_model')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.models')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.models_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{url()->current()==route('admin.colors') || url()->current()==route('admin.color.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-layer-group"></i>
                <div data-i18n="Layouts">@lang('trs.colors')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.color.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_color')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.colors')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.colors_list')</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{url()->current()==route('admin.admins') || url()->current()==route('admin.admin.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-user-tie"></i>
                <div data-i18n="Layouts">@lang('trs.admins')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.admin.create') }}" class="menu-link">
                        <i class="fa-solid fa-user-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_admin')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.admins')}}" class="menu-link">
                        <i class="fa-solid fa-users-gear"></i>
                        <div data-i18n="Vertical">@lang('trs.admins_list')</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{url()->current()==route('admin.base_services') || url()->current()==route('admin.base_service.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon fa-solid fa-hands-bubbles"></i>
                <div data-i18n="Layouts">@lang('trs.base_services')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.base_service.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_service')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.base_services')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.services_list')</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{url()->current()==route('admin.roles') || url()->current()==route('admin.role.create') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon  fa-solid fa-user-lock"></i>
                <div data-i18n="Layouts">@lang('trs.roles')</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('admin.role.create') }}" class="menu-link">
                        <i class="fa-solid fa-circle-plus"></i>
                        <div data-i18n="Without menu">@lang('trs.add_role')</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{route('admin.roles')}}" class="menu-link">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <div data-i18n="Vertical">@lang('trs.roles_list')</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-item {{url()->current()==route('admin.settings') ? 'active' : ''}}">
            <a href="{{route('admin.settings')}}" class="menu-link ">
                <i class="menu-icon fa-solid fa-gears"></i>
                <div data-i18n="Dashboards">@lang('trs.settings')</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('logout')}}" class="menu-link">
                <i class="menu-icon agh-logout"></i>
                <div data-i18n="Dashboards">خروج</div>
            </a>
        </li>
    </ul>
</aside>
