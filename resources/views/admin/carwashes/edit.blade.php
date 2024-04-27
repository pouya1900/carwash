@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.edit_carwash')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.edit_carwash')</h5>
                <form action="{{ route('admin.carwash.update',$carwash->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="row mg-b-10">
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="title">عنوان</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="title" name="title"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$carwash->title}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="mobile">موبایل</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="mobile" name="mobile"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$carwash->mobile}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mg-b-10">
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="status">وضعیت</label>
                                <div class="input-group">
                                    <select class="form-control boxaitradeselect" name="status" id="status">
                                        <option value="">انتخاب وضعیت...</option>
                                        <option
                                            {{$carwash->status=="pending" ? "selected" : ""}} value="pending">{{\App\Helper::turn_carwash_status("pending")}}</option>
                                        <option
                                            {{$carwash->status=="accepted" ? "selected" : ""}} value="accepted">{{\App\Helper::turn_carwash_status("accepted")}}</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="balance">موجودی</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start number_format_input" id="balance"
                                           name="balance"
                                           dir="ltr"
                                           placeholder="" required="" value="{{$carwash->balance}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mg-b-10">
                            <div class="col-12">
                                <label class="form-label">تصویر پروفایل</label>

                                <div id="app">
                                    <image-input-preview att_name="logo"
                                                         src="{{$carwash->logo["model"] ? $carwash->logo["paths"]["standard"] : ""}}">
                                    </image-input-preview>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn-secondary full-width">
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
