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
                        <th>شماره</th>
                        <th>خدمت</th>
                        <th>محصولات</th>
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
                            <td data-th="شماره">{{$reservation->id}}</td>
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
                                <span
                                    class="{{\App\Helper::reservationStatusCSS($reservation->status)}}">{{\App\Helper::reservationStatus($reservation->status)}}</span>
                            </td>
                            <td data-th="هزینه">{{number_format($reservation->price)}} @lang("trs.toman")</td>
                            <td data-th="تاریخ" style="direction: ltr">
                                {{jdate(strtotime($reservation->time->start))->format("Y-n-j H:i")}}
                            </td>
                            <td data-th="مدیریت">
                                <ul class="ulinlin fsize13">
                                    @if ($reservation->status=="doing")
                                        <li class="mgright10"><a class="no_hover_a"
                                                                 href="{{route('carwash_reservation_update',$reservation->id)}}">اتمام</a>
                                        </li>
                                    @endif
                                </ul>
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
            $('#example').DataTable({
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
