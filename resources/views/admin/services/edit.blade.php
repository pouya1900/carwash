@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.edit_service')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%" id="app">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.edit_service')</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <form action="{{route("admin.service.update",$service->id)}}" method="post">
                        {{csrf_field()}}
                        <add-service :base_services="{{json_encode($base_services)}}"
                                     :items="{{$items}}"
                                     :service="{{$service}}"
                                     :types="{{$types}}"></add-service>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection
