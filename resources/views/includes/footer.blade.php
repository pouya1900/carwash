<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-4  col-md-6 boxfooter1">
                <img src="{{$setting->logo['path']}}" title="{{$setting->title}}" alt="{{$setting->title}}">
                <p>
                    @lang('trs.footer_description_text')
                </p>
            </div>
            <div class="col-lg-4 col-md-6 boxfooter2">
                <ul>
                    <li><span><i class="fa-solid fa-phone-volume"></i>تلفن  </span>{{$setting->phone}}</li>
                    <li><span><i class="fa-solid fa-envelope"></i>ایمیل   </span>{{$setting->email}}</li>
                    <li><span><i class="fa-solid fa-location-dot"></i>آدرس  </span>{{$setting->address}}</li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-12 boxfooter3">
                <span class="titlefooter">دسترسی سریع</span>
                <ul>
                    <li><a href="{{route('home')}}">@lang('trs.site_main_page')</a></li>
                    <li><a href="{{route('login','user')}}">@lang('trs.user_panel')</a></li>
                    <li><a href="{{route('login','servant')}}">@lang('trs.servant_panel') </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">
        @lang('trs.copy_right')
    </div>
</footer>
