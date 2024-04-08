@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.add_new_service')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.add_new_service')</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">

                    <div id="app">
                        <add-service-attribute
                            :trs="{{json_encode(trans('trs'))}}"
                            :categories="{{json_encode($categories)}}"
                            :servant="{{json_encode($servant)}}"
                            :parents_place="{{json_encode($parents_place)}}"
                            :search_url="{{json_encode(route('servant_service_search'))}}"
                            :insurances="{{json_encode($insurances)}}"
                            :children="{{json_encode($children)}}"
                            :submit_form_url="{{json_encode(route('servant_service_store'))}}"
                            :csrf="{{json_encode(csrf_token())}}"
                            :units="{{json_encode($units)}}"></add-service-attribute>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection
