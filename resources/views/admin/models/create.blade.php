@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.add_model')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.new_model')</h5>
                <form action="{{ route('admin.model.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label class="form-label" for="brand">برند</label>
                                <div class="input-group">
                                    <select class="form-control boxaitradeselect" name="brand" id="brand">
                                        <option value="0">انتخاب برند...</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-12 mg-b-10">
                                <label class="form-label" for="type">نوع</label>
                                <div class="input-group">
                                    <select class="form-control boxaitradeselect" name="type" id="type">
                                        <option value="0">انتخاب نوع...</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

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
