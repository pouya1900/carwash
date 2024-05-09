@extends('layouts.carwash')

@section('style')
@endsection


@section('title')
    <span class="titlescc">ویرایش پروفایل</span>
@endsection

@section('content')

    <div class="card">

        <div id="app" class="card-body ">
            <div class="profile_main">
                <div class="profile_main_content">

                    <form action="{{route('carwash_update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-around mg-b-10">
                            <div class="col-12 col-lg-6 mg-b-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="profile_main--avatar">

                                            <div>
                                                <change-avatar
                                                    :avatar="{{json_encode($carwash->logo['paths']["standard"])}}"
                                                    att_name="logo"></change-avatar>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="profile_main--name">

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-start"
                                                               id="title"
                                                               name="title" dir="rtl"
                                                               value="{{$carwash->title}}"
                                                               placeholder="@lang('trs.carwash_title')" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-start"
                                                           id="address"
                                                           name="address" dir="rtl"
                                                           value="{{$carwash->address}}"
                                                           placeholder="@lang('trs.address')" required="">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div>
                                    <change-mobile
                                        :trs="{{json_encode(trans("trs"))}}"
                                        :model="{{json_encode($carwash)}}"
                                        :csrf="{{json_encode(csrf_token())}}"
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

@endsection
