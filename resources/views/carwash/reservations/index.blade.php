@extends('layouts.servant')

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
                        <th>خدمات</th>
                        <th>کاربر</th>
                        <th>وضعیت</th>
                        <th>هزینه</th>
                        <th>تاریخ</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($reservations as $reservation)
                        <tr>
                            <td>
                                @foreach($reservation->services as $key=>$service)
                                    @if ($key>0)
                                        {{"، "}}
                                    @endif
                                    {{$service->title}}
                                @endforeach
                            </td>
                            <td>{{$reservation->user?->fullName}}</td>
                            <td>
                                @if($reservation->status == "requested")
                                    <span class="btn-label-info">@lang('trs.res_status_requested')</span>
                                @elseif($reservation->status == "canceled")
                                    <span class="btn-label-warning">@lang('trs.res_status_canceled')</span>
                                @elseif($reservation->status == "rejected")
                                    <span class="btn-label-warning">@lang('trs.res_status_rejected')</span>
                                @elseif($reservation->status == "accepted")
                                    <span class="btn-label-success">@lang('trs.res_status_accepted')</span>
                                @elseif($reservation->status == "asked")
                                    <span class="btn-label-info">@lang('trs.res_status_asked')</span>
                                @elseif($reservation->status == "doing")
                                    <span class="btn-label-success">@lang('trs.res_status_doing')</span>
                                @elseif($reservation->status == "done")
                                    <span class="btn-label-success">@lang('trs.res_status_done')</span>
                                @elseif($reservation->status == "finished")
                                    <span class="btn-label-success">@lang('trs.res_status_finished')</span>
                                @elseif($reservation->status == "sued")
                                    <span class="btn-label-warning">@lang('trs.res_status_sued')</span>
                                @else
                                    ---
                                @endif
                            </td>
                            <td>{{number_format($reservation->price)}} @lang("trs.rial")</td>
                            <td>
                                {{jdate(strtotime($reservation->created_at))->format("Y-n-j")}}
                            </td>
                            <td>
                                <ul class="ulinlin fsize13">
                                    <li class="mgright10"><a class="no_hover_a"
                                                             href="{{route('servant_reservation_show',$reservation->id)}}">نمایش</a>
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
