@extends('layouts.servant')

@section('style')
    <link href="storage/css/nanogallery2.min.css" rel="stylesheet">
@endsection


@section('title')
    <span class="titlescc">ویرایش پروفایل</span>
@endsection

@section('content')

    <div class="card">

        <div id="app" class="card-body ">
            <div class="profile_main">
                <div class="profile_main_content">

                    <form action="{{route('servant_update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-around mg-b-10">
                            <div class="col-12 col-lg-6">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="profile_main--avatar">

                                            <div>
                                                <change-avatar
                                                    :avatar="{{json_encode($servant->avatar['path'])}}"></change-avatar>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="profile_main--name">

                                            <div class="row">
                                                <div class="col-12 mg-b-10">
                                                    اگر شما یک مرکز درمانی هستید در قسمت نام نوع مرکز برای مثال :
                                                    بیمارستان، کلینیک و... را و در قسمت نام خانوادگی اسم مرکز را قرار
                                                    دهید مثلا : شهید رجایی
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-start"
                                                               id="first_name"
                                                               name="first_name" dir="rtl"
                                                               value="{{$servant->first_name}}"
                                                               placeholder="@lang('trs.first_name')" required="">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-start"
                                                               id="last_name"
                                                               name="last_name" dir="rtl"
                                                               value="{{$servant->last_name}}"
                                                               placeholder="@lang('trs.last_name')" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-start"
                                                           id="title"
                                                           name="title" dir="rtl"
                                                           value="{{$servant->title}}"
                                                           placeholder="@lang('trs.title')" required="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="">
                                    <label class="form-label"
                                           for="is_place">@lang("trs.are_you_a_place")</label>
                                    <input class="form-check-input" name="is_place" type="checkbox"
                                           {{$servant->is_place ? "checked" : ""}}
                                           id="is_place">
                                </div>
                                <br>

                                <div>
                                    <change-mobile
                                        :trs="{{json_encode(trans("trs"))}}"
                                        :servant="{{json_encode($servant)}}"
                                        :send_otp_url="{{json_encode(route("send_otp"))}}"></change-mobile>
                                </div>


                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-around">
                            <div class="col-4 text-center">
                                <button type="submit" class="btn btn-secondary full-width">
                                    @lang('trs.submit')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





@endsection

@section('script')
    <script type="text/javascript" src="storage/js/jquery.nanogallery2.min.js"></script>

    <script>
        $("#my_nanogallery2").nanogallery2({
            "thumbnailHeight": 300,
            "thumbnailWidth": 'auto',
            galleryTheme: {
                thumbnail: {borderRadius: '15px'},
            },
            thumbnailLabel: {valign: 'middle'},

        });
    </script>
@endsection
