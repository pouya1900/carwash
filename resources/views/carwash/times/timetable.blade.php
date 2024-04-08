@extends('layouts.servant')

@section('style')
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
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.week_times')</h5>
        <div class="table-responsive text-nowrap">

            <div id="app">
                <timetable :trs="{{json_encode(trans('trs'))}}"
                           :days="{{json_encode($days)}}"
                           :csrf="{{json_encode(csrf_token())}}"
                           :url="{{json_encode(route('servant_timetable_update'))}}"
                           :schedule="{{json_encode($schedule)}}">

                </timetable>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
