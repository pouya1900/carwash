@extends('layouts.carwash')

@section('style')
    <style>
        .mu-container {
            background: var(--color2) !important;
        }

    </style>
@endsection

@section('title')
    <span class="titlescc">@lang('trs.new_withdraw')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.new_withdraw')</h5>
                <form action="{{ route('carwash_withdraw_store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="mg-b-10">
                            <label class="form-label" for="price">مبلغ (موجودی : {{number_format($carwash->balance)}} @lang("trs.toman"))</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start number_format_input" id="price" name="price" dir="lte"
                                       placeholder="" required="">
                            </div>
                        </div>
                        <div class="mg-b-10">
                            <label class="form-label" for="bank" style="margin-bottom: 10px;">بانک</label>
                            <div class="input-group">
                                <select class="form-control boxaitradeselect" id="bank" name="bank">
                                    @foreach($carwash->banks as $bank)
                                        <option value="{{$bank->id}}">{{$bank->name .' - ' . $bank->card}}</option>
                                    @endforeach
                                </select>
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
