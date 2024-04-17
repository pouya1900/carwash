@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.add_new_bank_card')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.add_new_bank_card')</h5>
                <form action="{{ route('carwash_bank_store') }}" method="POST">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="">
                            <label class="form-label" for="name">نام بانک</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="name" name="name" dir="rtl"
                                       placeholder="" required="" >
                            </div>
                        </div>

                        <div class="">
                            <label class="form-label" for="card">شماره کارت</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="card" name="card" dir="ltr"
                                       placeholder="" required="" minlength="16" maxlength="16">
                            </div>
                        </div>

                        <div class="">
                            <label class="form-label" for="shaba">شماره شبا</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="shaba" name="shaba" dir="ltr"
                                       placeholder="" required="">
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
