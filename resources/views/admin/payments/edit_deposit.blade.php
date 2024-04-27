@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.edit_withdraw')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.edit_withdraw')</h5>
                <form action="{{ route('admin.deposit.update',$deposit->id) }}" method="POST">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">


                        <div class="mg-b-10">
                            <label class="form-label" for="status"
                                   style="margin-bottom: 10px;">@lang('trs.status')</label>
                            <div class="input-group">
                                <select class="form-control boxaitradeselect" name="status" id="status">
                                    <option value="">انتخاب وضعیت...</option>
                                    <option
                                        {{$deposit->status=="requested" ? "selected" : ""}} value="requested">@lang('trs.requested_withdraw')</option>
                                    <option
                                        {{$deposit->status=="rejected" ? "selected" : ""}} value="rejected">@lang('trs.rejected')</option>
                                    <option
                                        {{$deposit->status=="completed" ? "selected" : ""}} value="completed">@lang('trs.completed')</option>
                                    <option
                                        {{$deposit->status=="pending" ? "selected" : ""}} value="pending">@lang('trs.pending_withdraw')</option>
                                </select>
                            </div>
                        </div>

                        <div class="mg-b-10">
                            <label class="form-label" for="message">پیام(در صورت ناموفق بودن دلیل ان را
                                بنویسید.)</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="message" name="message" dir="rtl"
                                       placeholder="مثلا : بانک نامعتبر است." value="{{$deposit->message}}">
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
