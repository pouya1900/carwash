@include('includes.layout_top')

@include('includes.load_screen')

<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('carwash.partials.side_bar')

        <div class="layout-page">
            @include('carwash.partials.top_bar')
            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y bx1">
                    @include('includes.error_message')

                    @yield('title')


                    @yield('content')
                </div>


            </div>
        </div>


@include('includes.layout_bottom')





