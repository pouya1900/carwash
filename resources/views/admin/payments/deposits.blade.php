@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.financial')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.withdraws')</h5>
        <div class="table-responsive text-nowrap">
            @if ($carwash)
                <p>خدمت دهنده : {{$carwash->fullName}}</p>
            @endif
            @if (count($deposits))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>کارواش</th>
                        <th>مبلغ</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th>بانک</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($deposits as $key=>$deposit)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$deposit->carwash?->fullName}}</td>
                            <td>{{number_format($deposit->total)}} @lang("trs.toman")</td>
                            <td>{{\App\Helper::turn_withdraw_status($deposit->status)}}</td>
                            <td>{{jdate($deposit->created_at)->format('Y-m-d H:i')}}</td>
                            <td>
                                <ul>
                                    <li>{{$deposit->bank?->name}}</li>
                                    <li>{{$deposit->bank?->card}}</li>
                                    <li>{{$deposit->bank?->shaba}}</li>
                                </ul>
                            </td>
                            <td>
                                @if ($deposit->status!="rejected")
                                    <ul class="ulinlin fsize13">
                                        <li class="mgright10"><a class="no_hover_a"
                                                                 href="{{route('admin.deposit.edit',$deposit->id)}}">ویرایش</a>
                                        </li>
                                    </ul>
                                @endif

                            </td>
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
