@extends('layouts.carwash')

@section('style')
@endsection


@section('title')
    <span class="titlescc">داشبورد من</span>
@endsection

@section('content')

    <div class="card">

        <div class="card-body ">
            <div class="profile_main">
                <div class="profile_main_content">

                    <div class="row justify-content-around">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-2">
                                    <div class="profile_main--avatar">
                                        <img src="{{$carwash->logo['paths']["standard"]}}" title="" alt="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="profile_main--name">
                                        <p>{{$carwash->title}}</p>
                                        <p>{{$carwash->address}}</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <p>{{$carwash->mobile}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col-4 text-center">
                            <a href="{{route('carwash_edit')}}" class="edit_profile_button">
                                ویرایش پروفایل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection

@section('script')

@endsection
