<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

            <div class="navbar-nav align-items-center">
                <!-- User -->
                <div class="nav-item navbar-dropdown dropdown-user dropdown">
                    <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                                <img src="{{$admin->avatar['path']}}" alt
                                     class="rounded-circle">
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="fw-semibold d-block lh-1">{{$admin->fullName}}</span>
                        </div>
                    </div>
                </div>
                <!--/ User -->
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">


                <!-- Notification -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown">

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
