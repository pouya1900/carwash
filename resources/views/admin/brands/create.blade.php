@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.add_brand')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.new_brand')</h5>
                <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <div class="row mg-b-10">
                            <div class="col-6 mg-b-10">
                                <label class="form-label" for="title">عنوان</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="title" name="title" dir="rtl"
                                           placeholder="" required="">
                                </div>
                            </div>

                            <div class="col-12 mg-b-10">
                                <label class="form-label" for="description">توضیحات</label>
                                <div class="input-group">
                                    <textarea class="form-control text-start" id="description"
                                              name="description" dir="rtl"></textarea>
                                </div>
                            </div>

                            <div class="col-12 mg-b-10">
                                <label class="form-label">انواع</label>
                                @foreach($types as $type)
                                    <div class="form-check">
                                        <label class="form-label"
                                               for="type_{{$type->id}}">{{$type->title}}</label>
                                        <input class="form-check-input" name="types[]" type="checkbox"
                                               value="{{$type->id}}"
                                               id="type_{{$type->id}}">
                                    </div>
                                @endforeach

                            </div>

                            <div class="col-12">
                                <label class="form-label">لوگو</label>
                                <div id="app">
                                    <image-input-preview att_name="logo" src="">
                                    </image-input-preview>
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
@endsection

@section('script')

@endsection
