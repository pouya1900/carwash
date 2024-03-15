@extends('layouts.pure')

@section("content")

    <div class="web_view_payment_result">

        <div class="web_view_payment_result_body">
            @if ($ref_id)
                <p class="success_payment">@lang('messages.payment.completed')</p>
                @if ($ref_id==1)
                    <p class="success_payment">مبلغ مورد نظر از حساب کاربری شما برداشت شد.</p>
                @else
                    <p class="success_payment">شماره تراکنش : {{$ref_id}}</p>
                @endif
            @else
                <p class="failed_payment">@lang('messages.payment.verifyFailed')</p>
            @endif

            <div class="">
                <a href="#" class="btn btn-secondary return_to_app">بازگشت به برنامه</a>
            </div>
        </div>


    </div>

@endsection
