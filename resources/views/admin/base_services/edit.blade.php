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
                    <form action="{{route("admin.base_service.update",$service->id)}}" method="post">
                        {{csrf_field()}}
                        <div class="card-body demo-vertical-spacing demo-only-element">

                            <div class="row mg-b-10">
                                <div class="col-6 mg-b-10">
                                    <label class="form-label" for="title">عنوان</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control text-start" id="title" name="title"
                                               dir="rtl"
                                               placeholder="" value="{{$service->title}}" required="">
                                    </div>
                                </div>

                                <div class="col-12 mg-b-10">
                                    <label class="form-label" for="description">توضیحات</label>
                                    <div class="input-group">
                                    <textarea class="form-control text-start" id="description"
                                              name="description" dir="rtl">{{$service->description}}</textarea>
                                    </div>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-secondary full-width">
                                @lang('trs.submit')
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection
