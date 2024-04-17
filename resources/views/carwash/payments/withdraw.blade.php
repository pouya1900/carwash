@extends('layouts.carwash')

@section('title')
    <span class="titlescc">مالی</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">لیست برداشت ها</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>مبلغ</th>
                    <th>کارت</th>
                    <th>تاریخ</th>
                    <th>وضعیت</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($carwash->deposits()->orderBy("created_at","desc")->get() as $deposit)
                    <tr>
                        <td>{{number_format($deposit->total)}} @lang("trs.toman")</td>
                        <td>{{$deposit->bank?->card}}</td>
                        <td>{{jdate($deposit->created_at)->format('Y-m-d')}}</td>
                        <td class="{{\App\Helper::turn_withdraw_statusCSS($deposit->status)}}">{{\App\Helper::turn_withdraw_status($deposit->status)}}</td>
                        <td>
                            <ul class="ulinlin fsize13">
                                <li>
                                    @if ($deposit->status == "requested")
                                        <button style="background:none;border: none;"
                                                onclick='functionConfirm("آیا از لغو درخواست اطمینان دارید ؟", function yes() {
                                                    window.location.replace("{{route('carwash_withdraw_delete',$deposit->id)}}");
                                                    },
                                                    function no() {
                                                    });'>لغو
                                        </button>
                                    @endif
                                </li>
                            </ul>
                            <div id="confirm">
                                <div class="message"></div>
                                <button class="yes">بله</button>
                                <button class="no">خیر</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function functionConfirm(msg, myYes, myNo) {
            var confirmBox = $("#confirm");
            confirmBox.find(".message").text(msg);
            confirmBox.find(".yes,.no").unbind().click(function () {
                confirmBox.hide();
            });
            confirmBox.find(".yes").click(myYes);
            confirmBox.find(".no").click(myNo);
            confirmBox.show();
        }
    </script>
@endsection
