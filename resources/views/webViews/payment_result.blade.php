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

                <div class="">
                    <a href="{{route("deep_link_success",["refId"=>$ref_id , "amount"=>$amount])}}"
                       class="btn btn-secondary return_to_app">بازگشت به برنامه</a>
                </div>
            @else
                <p class="failed_payment">@lang('messages.payment.verifyFailed')</p>

                <div class="">
                    <p id="return_to_app">اگر تا <span data-time="5" id="return_to_app_second">5</span> ثانیه دیگر به
                        طور خودکار به برنامه بازنگشتید دکمه زیر را لمس
                        کنید.</p>
                    <a href="{{route("deep_link_failed",["amount"=>$amount])}}"
                       class="btn btn-secondary return_to_app">بازگشت به برنامه</a>
                </div>
            @endif


        </div>


    </div>

@endsection

@section("script")
    <script>

        function d_time() {
            let x = $("#return_to_app_second");
            let t = x.data("time");
            let n_t = parseInt(t) - 1;
            x.html(n_t);
            x.data("time", n_t);
            console.log(n_t);
            if (n_t > 0) {
                setTimeout(() => d_time(), 1000);
            } else {
                window.location.href = "{{$ref_id==1 ? route("deep_link_success",["refId"=>$ref_id , "amount"=>$amount]) : route("deep_link_failed",["amount"=>$amount])}}";
            }
        }

        d_time();
    </script>
@endsection
