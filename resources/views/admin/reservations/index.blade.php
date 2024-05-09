@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.reservations_list')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.reservations_list')</h5>

        @if ($carwash)
            <p>کارواش : {{$carwash->title}}</p>
        @endif

        <div class="table-responsive text-nowrap">
            @if (count($reservations))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>کارواش</th>
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
                            <td data-th="کارواش">{{$reservation->carwash?->title}}</td>
                            <td data-th="خدمت">{{$reservation->services()->first()?->title}}</td>
                            <td data-th="محصولات">
                                @foreach($reservation->products as $key=>$product)
                                    @if ($key>0)
                                        {{"، "}}
                                    @endif
                                    {{$product->title}}
                                @endforeach
                            </td>
                            <td data-th="کاربر">{{$reservation->user?->fullName}} {{$reservation->user && $reservation->user->car ? ("- ".$reservation->user->car->type?->title) : ""}}</td>
                            <td data-th="وضعیت">
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
                            <td data-th="هزینه">{{number_format($reservation->price)}} @lang("trs.toman")</td>
                            <td data-th="تاریخ" style="direction: ltr">
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
