@extends('layouts.pure')

@php($setting->logo_src=$setting->logo['path'])
@section('content')
    <div id="app">
        <login :trs="{{json_encode(trans('trs'))}}"
               :csrf="{{json_encode(csrf_token())}}"
               :base_url="{{json_encode(route('home'))}}"
               :send_otp_url="{{json_encode(route('send_otp'))}}"
               :login_url="{{$type =="carwash" ? json_encode(route('do_login_carwash')) : ($type =="admin" ? json_encode(route('do_login_admin')) : json_encode(route('do_login_user')))}}"
               :setting="{{json_encode($setting)}}"></login>
    </div>
@endsection
