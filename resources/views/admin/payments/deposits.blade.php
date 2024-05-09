@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.financial')</span>
@endsection

@section('content')
    <div class="card ticket">
        @if (!$user)
            <h5 class="card-header">@lang('trs.withdraws')</h5>
            <div class="m-4">
                <h6>لیست برداشت های کارواش ها</h6>
            </div>
            <div class="table-responsive text-nowrap">
                @if ($carwash)
                    <p>کارواش : {{$carwash->title}}</p>
                @endif
                @if (count($carwash_deposits))
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
                        @foreach($carwash_deposits as $key=>$deposit)
                            <tr>
                                <td data-th="ردیف">{{$key+1}}</td>
                                <td data-th="کارواش">{{$deposit->depositable?->title}}</td>
                                <td data-th="مبلغ">{{number_format($deposit->total)}} @lang("trs.toman")</td>
                                <td data-th="وضعیت">{{\App\Helper::turn_withdraw_status($deposit->status)}}</td>
                                <td data-th="تاریخ"
                                    class="left-to-right">{{jdate($deposit->created_at)->format('Y-m-d H:i')}}</td>
                                <td data-th="بانک">
                                    <ul>
                                        <li>{{$deposit->bank?->name}}</li>
                                        <li>{{$deposit->bank?->card}}</li>
                                        <li>{{$deposit->bank?->shaba}}</li>
                                    </ul>
                                </td>
                                <td data-th="مدیریت">
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

            <hr>
        @endif
        @if (!$carwash)
            <div class="m-4">
                <h6>لیست برداشت های کاربران</h6>
            </div>
            <div class="table-responsive text-nowrap">
                @if ($user)
                    <p>کاربر : {{$user->fullName}}</p>
                @endif
                @if (count($user_deposits))
                    <table class="table txtcenter" style="width: 95%">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>کاربر</th>
                            <th>مبلغ</th>
                            <th>وضعیت</th>
                            <th>تاریخ</th>
                            <th>بانک</th>
                            <th>مدیریت</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($user_deposits as $key=>$deposit)
                            <tr>
                                <td data-th="ردیف">{{$key+1}}</td>
                                <td data-th="کاربر">{{$deposit->depositable?->fullName}}</td>
                                <td data-th="مبلغ">{{number_format($deposit->total)}} @lang("trs.toman")</td>
                                <td data-th="وضعیت">{{\App\Helper::turn_withdraw_status($deposit->status)}}</td>
                                <td data-th="تاریخ"
                                    class="left-to-right">{{jdate($deposit->created_at)->format('Y-m-d H:i')}}</td>
                                <td data-th="بانک">
                                    <ul>
                                        <li>{{$deposit->bank?->name}}</li>
                                        <li>{{$deposit->bank?->card}}</li>
                                        <li>{{$deposit->bank?->shaba}}</li>
                                    </ul>
                                </td>
                                <td data-th="مدیریت">
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
        @endif

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
