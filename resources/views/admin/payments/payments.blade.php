@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.financial')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.payments')</h5>
        <div class="table-responsive text-nowrap">
            @if ($carwash)
                <p>خدمت دهنده : {{$carwash->fullName}}</p>
            @elseif($user)
                <p>کاربر : {{$user->fullName}}</p>
            @endif
            @if (count($payments))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>کاربر</th>
                        <th>کارواش</th>
                        <th>کیف پول</th>
                        <th>انلاین</th>
                        <th>مبلغ کل</th>
                        <th>تاریخ</th>
                        <th>شماره پیگیری</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($payments as $key=>$payment)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$payment->user?->fullName}}</td>
                            <td>{{$payment->reservation?->carwash?->fullName}}</td>
                            <td>{{number_format($payment->wallet)}} @lang("trs.toman")</td>
                            <td>{{number_format($payment->online)}} @lang("trs.toman")</td>
                            <td>{{number_format($payment->total)}} @lang("trs.toman")</td>
                            <td>{{jdate($payment->created_at)->format('Y-m-d')}}</td>
                            <td>{{$payment->ref_id}}</td>
                            <td>{{\App\Helper::turn_payment_status($payment->status)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="nodata">
                    <img src="storage/assets/siteContent/no_data_new1.png" alt="#" class="nodata_img">
                    <p class="nodata-text">اطلاعاتی وجود ندارد</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fa.json',
                },
            });
        });
    </script>
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
