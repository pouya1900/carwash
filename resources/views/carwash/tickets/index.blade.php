@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.tickets')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">لیست درخواست های پشتیبانی</h5>
        <div class="table-responsive text-nowrap">
            @if (count($tickets))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>موضوع</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($tickets as $ticket)
                        <tr>
                            <td data-th="موضوع">{{ $ticket->title }}</td>
                            <td data-th="وضعیت">
                                @if($ticket->status == "pending")
                                    <span class="btn-label-info">در انتظار پاسخ</span>
                                @elseif($ticket->status == "answered")
                                    <span class="btn-label-success">پاسخ داده شده</span>
                                @elseif($ticket->status == "closed")
                                    <span class="btn-label-warning">بسته شده</span>
                                @else
                                    ---
                                @endif
                            </td>
                            <td data-th="تاریخ">
                                {{jdate(strtotime($ticket->created_at))->format("Y-n-j")}}
                            </td>
                            <td data-th="مدیریت">
                                <ul class="ulinlin fsize13">
                                    <li class="mgright10"><a class="no_hover_a"
                                                             href="{{route('carwash_ticket_edit',$ticket->id)}}">پاسخ</a>
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
