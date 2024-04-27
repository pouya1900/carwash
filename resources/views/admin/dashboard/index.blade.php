@extends('layouts.admin')

@section("style")
    <link rel="stylesheet" href="storage/css/persianDatepicker-dark.css"/>
@endsection

@section('title')
    <span class="titlescc">@lang('trs.dashboard')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.dashboard')</h5>
        <div class="card-body demo-vertical-spacing demo-only-element">

            <div>
                <ul>
                    <li>موجودی کل کاربران : {{number_format($users_total_balance)}}</li>
                    <li>موجودی کل خدمت دهندگان : {{number_format($carwashes_total_balance)}}</li>
                </ul>
            </div>
            <div>
                <form method="get" action="{{route("admin.dashboard")}}">

                    <div class="row">
                        <div class="col-6 mg-b-10">
                            <label class="form-label" for="date1">از تاریخ</label>
                            <div class="input-group">
                                <input type="text" id="date1" class="form-control text-start" name="start"
                                       dir="rtl" value="{{$start}}"
                                       placeholder="" required="">
                            </div>

                            <span id="span1"></span>
                        </div>
                        <div class="col-6 mg-b-10">
                            <label class="form-label" for="date2">تا تاریخ</label>
                            <div class="input-group">
                                <input type="text" id="date2" class="form-control text-start" name="end"
                                       dir="rtl" value="{{$end}}"
                                       placeholder="" required="">
                            </div>

                            <span id="span2"></span>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-secondary half-width">جست و جو</button>
                        </div>
                    </div>

                </form>
            </div>

            @if ($start)
                <h6>از تاریخ {{$start}} تا تاریخ {{$end}}</h6>
            @else
                <h6>از شروع سامانه</h6>
            @endif

            <div>
                <ul>
                    <li>مجموع پرداختی کاربران : {{number_format($users_total_payment)}}</li>
                    <li>مجموع پرداختی به خدمت دهندگان : {{number_format($carwashes_total_deposit)}}</li>
                    <li>موجودی سامانه (تفاوت مبالغ دریافت شده از کاربران و واریز شده به خدمت دهندگان)
                        : {{number_format($users_total_payment - $carwashes_total_deposit)}}</li>
                    <li>کل درامد خدمت دهندگان : {{number_format($carwashes_total_income)}}</li>
                    <li>کل درامد سامانه : {{number_format($system_total_income)}}</li>
                </ul>
                @if ($start)
                    <div class="">
                        <a href="{{route("admin.dashboard")}}" type="submit" class="btn btn-secondary half-width">جست و
                            جو بدون تاریخ</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="storage/js/persianDatepicker.min.js"></script>


    <script type="text/javascript">
        $(function () {
            $("#date1, #span1").persianDatepicker({
                theme: 'dark',
                formatDate: 'YYYY/0M/0D',
            });
        });
        $(function () {
            $("#date2, #span2").persianDatepicker({
                theme: 'dark',
                formatDate: 'YYYY/0M/0D',
            });
        });
    </script>


@endsection
