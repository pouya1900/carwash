@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.tickets')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">لیست درخواست های پشتیبانی {{$type=="user" ? "کاربران" : "خدمت دهندگان"}}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>موضوع</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($tickets as $key=>$ticket)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $ticket->title }}</td>
                        <td>
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
                        <td>
                            {{jdate(strtotime($ticket->created_at))->format("Y-n-j")}}
                        </td>
                        <td>
                            <ul class="ulinlin fsize13">
                                <li>
                                    @if($ticket->status != "closed")
                                        <button style="background:none;border: none;"
                                                onclick='functionConfirm("آیا از بستن تیکت اطمینان دارید ؟", function yes() {
                                                    window.location.replace("{{route("admin.ticket.close",$ticket->id)}}");
                                                    },
                                                    function no() {
                                                    });'>بستن
                                        </button>
                                    @endif
                                </li>
                                <li class="mgright10">
                                    <a class="no_hover_a" href="{{route('admin.ticket.edit',$ticket->id)}}">
                                        {{$ticket->status != "closed" ? "پاسخ" : "مشاهده"}}
                                    </a>
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
