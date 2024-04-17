@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.reservations_list')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.reservations_list')</h5>
        <div class="table-responsive text-nowrap">
            @if (!empty($reservations))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>خدمت</th>
                        <th>محصولات</th>
                        <th>کاربر</th>
                        <th>وضعیت</th>
                        <th>هزینه</th>
                        <th>تاریخ</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>{{$reservation->services()->first()?->title}}</td>
                            <td>
                                @foreach($reservation->products as $key=>$product)
                                    @if ($key>0)
                                        {{"، "}}
                                    @endif
                                    {{$product->title}}
                                @endforeach
                            </td>
                            <td>{{$reservation->user?->fullName}} {{$reservation->user && $reservation->user->car ? ("- ".$reservation->user->car->type?->title) : ""}}</td>
                            <td>
                                @if($reservation->status == "canceled")
                                    <span class="btn-label-warning">@lang('trs.res_status_canceled')</span>
                                @elseif($reservation->status == "approved" && $reservation->time->end < \Carbon\Carbon::now()->addHour())
                                    <span class="btn-label-success">@lang('trs.res_status_finished')</span>
                                @elseif($reservation->status == "approved")
                                    <span class="btn-label-info">@lang('trs.res_status_approved')</span>
                                @else
                                    ---
                                @endif
                            </td>
                            <td>{{number_format($reservation->price)}} @lang("trs.toman")</td>
                            <td style="direction: ltr">
                                {{jdate(strtotime($reservation->time->start))->format("Y-n-j H:i")}}
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
