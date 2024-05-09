<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="fa-solid fa-bars"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <div class="navbar-nav align-items-center">
                <!-- User -->
                <div class="nav-item navbar-dropdown dropdown-user dropdown">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="{{$carwash->logo['paths']["standard"]}}" alt
                                     class="rounded-circle">
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block lh-1">{{$carwash->title}}</span>
                        </div>

                        <div class="flex-grow-1 margin-right-10">
                            <span class="fw-semibold d-block lh-1">موجودی : {{number_format($carwash->balance)}} @lang('trs.toman')</span>
                        </div>

                    </div>
                </div>
                <!--/ User -->
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">


                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown">
                    <a class="nav-link hide-arrow" href="{{route("carwash_notifications")}}">
                        <i class="fa-regular fa-bell"></i>
                        @if ($carwash->notifications()->where("seen",0)->count())
                            <span
                                class="badge bg-danger rounded-pill badge-notifications">
                            {{$carwash->notifications()->where("seen",0)->count() ?: ""}}
                        </span>
                        @endif

                        <span class="nttitle">اطلاعیه ها </span>
                    </a>
                </li>
                <!--/ Notification -->
                <!-- Style Switcher -->
            {{--                <li class="nav-item me-2 me-xl-0">--}}
            {{--                    <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">--}}
            {{--                        <i class="bx  bx-sm"></i>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            <!--/ Style Switcher -->


            </ul>
        </div>
    </div>
</nav>
