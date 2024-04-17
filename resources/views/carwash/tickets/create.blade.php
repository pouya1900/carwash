@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.add_new_ticket')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.add_new_ticket')</h5>
                <form action="{{ route('carwash_ticket_store') }}" method="POST">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="">
                            <label class="form-label" for="title">عنوان درخواست</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="title" name="title" dir="rtl"
                                       placeholder="" required="">
                            </div>
                        </div>

                        <div class="">
                            <label class="form-label" for="message" style="margin-bottom: 10px;">متن
                                درخواست</label>
                            <div class="input-group">
                                    <textarea name="message" class="form-control" id="message"
                                              rows="3"></textarea>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary full-width">
                            <i class="fa-solid fa-plus"></i>@lang('trs.send_request')
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection
