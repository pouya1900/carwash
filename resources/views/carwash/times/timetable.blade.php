@extends('layouts.carwash')

@section('style')
    <link rel="stylesheet" href="storage/css/owl.carousel.min.css">

    <style>
        body {
            padding-right: 0 !important;
            overflow: unset !important;
        }
    </style>
@endsection

@section('title')
    <span class="titlescc">@lang('trs.times_table')</span>
@endsection

@section('content')
    <div class="card ticket" id="app">
        <h5 class="card-header">@lang('trs.week_times')</h5>
        <div class="table-responsive text-nowrap display-none d-lg-block">

            <div>
                <div class="">
                    <timetable :trs="{{json_encode(trans('trs'))}}"
                               :days="{{json_encode($days)}}"
                               :csrf="{{json_encode(csrf_token())}}"
                               :url="{{json_encode(route('carwash_timetable_update'))}}"
                               :schedule="{{json_encode($schedule)}}">

                    </timetable>
                </div>
            </div>
        </div>
        <div class="text-nowrap d-lg-none">
            <div>
                <div class="">
                    <timetable-mobile :trs="{{json_encode(trans('trs'))}}"
                                      :days="{{json_encode($days)}}"
                                      :csrf="{{json_encode(csrf_token())}}"
                                      :url="{{json_encode(route('carwash_timetable_update'))}}"
                                      :schedule="{{json_encode($schedule)}}">
                    </timetable-mobile>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="storage/js/owl.carousel.min.js"></script>
@endsection
