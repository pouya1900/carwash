@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.times_table')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.week_times')</h5>
        <div class="table-responsive text-nowrap">

            <div id="app">
                <week-times :trs="{{json_encode(trans('trs'))}}"
                            :url="{{json_encode(route('servant_time_update'))}}"
                            :schedule="{{json_encode($schedule)}}"
                            :csrf="{{json_encode(csrf_token())}}"></week-times>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
