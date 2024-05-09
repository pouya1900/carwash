<!-- Loading bar -->
<section id="load-screen">
    <!-- right id is ( load-screen ) -->
    <div class="looding-in">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-lg-6 text-center">
                    <!-- Loading -->
                    <div class="loading-page">
                        <div class="counter">
                            <div class="text-center"><a href="{{route('home')}}"><img class="load_screen_image" src="{{$setting->logo['path']}}" alt=""></a></div>
                            <div class="loading-page-bar">
                                <div class="animation loading-page-progress"></div>
                            </div>
                            <div>@lang('trs.loading') <span class="num">0%</span></div>
                        </div>
                    </div>
                    <!-- // Loading -->
                </div>
            </div>
            <!-- // row -->
        </div>
        <!-- // container -->
    </div>
</section>
<!-- // Loading bar -->
