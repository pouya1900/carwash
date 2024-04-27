@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.edit_user')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.edit_user')</h5>
                <form action="{{ route('admin.user.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="row mg-b-10">
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="first_name">نام</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="first_name" name="first_name"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$user->first_name}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="last_name">نام خانوادگی</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="last_name" name="last_name"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$user->last_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mg-b-10">
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="mobile">موبایل</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="mobile" name="mobile"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$user->mobile}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="email">ایمیل</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="email" name="email"
                                           dir="ltr"
                                           placeholder="اختیاری" value="{{$user->email}}">
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
                                            {{$user->status=="active" ? "selected" : ""}} value="active">{{\App\Helper::turn_user_status("active")}}</option>
                                        <option
                                            {{$user->status=="inactive" ? "selected" : ""}} value="inactive">{{\App\Helper::turn_user_status("inactive")}}</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="balance">موجودی</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start number_format_input" id="balance"
                                           name="balance"
                                           dir="ltr"
                                           placeholder="" required="" value="{{$user->balance}}">
                                </div>
                            </div>
                        </div>

                        <div class="row mg-b-10">
                            <div class="col-12">
                                <label class="form-label">تصویر پروفایل</label>

                                <div id="app">
                                    <image-input-preview att_name="avatar"
                                                         src="{{$user->avatar["model"] ? $user->avatar["paths"]["standard"] : ""}}">
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
