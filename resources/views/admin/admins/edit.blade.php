@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.edit_admin')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.edit_admin')</h5>
                <form action="{{ route('admin.admin.update',$administrator->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="row mg-b-10">
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="first_name">نام</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="first_name" name="first_name"
                                           dir="rtl" value="{{$administrator->first_name}}"
                                           placeholder="" required="">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="last_name">نام خانوادگی</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="last_name" name="last_name"
                                           dir="rtl" value="{{$administrator->last_name}}"
                                           placeholder="" required="">
                                </div>
                            </div>

                            <div class="col-6 mg-b-10">
                                <label class="form-label" for="mobile">موبایل</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="mobile" name="mobile"
                                           dir="ltr" value="{{$administrator->mobile}}"
                                           placeholder="" required="">
                                </div>
                            </div>
                            <div class="col-6 mg-b-10">
                                <label class="form-label" for="role">نقش</label>
                                <div class="input-group">
                                    <select class="form-control boxaitradeselect" name="role" id="role">
                                        <option value="0">انتخاب نقش...</option>
                                        @foreach($roles as $role)
                                            <option
                                                {{$administrator->role->id==$role->id ? "selected" : ""}} value="{{$role->id}}">{{$role->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="col-12">
                                <label class="form-label">تصویر پروفایل</label>

                                <div id="app">
                                    <image-input-preview att_name="avatar"
                                                         src="{{$administrator->avatar["model"] ? $administrator->avatar["paths"]["standard"] : ""}}">
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
