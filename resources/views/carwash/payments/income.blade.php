@extends('layouts.carwash')

@section('title')
    <span class="titlescc">مالی</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">لیست درامد ها</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>سفارش</th>
                    <th>دریافتی شما</th>
                    <th>مبلغ کل</th>
                    <th>کارمزد</th>
                    <th>تاریخ</th>
                    <th>موجودی</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($carwash->releases()->orderBy("created_at","desc")->get() as $release)
                    <tr>
                        <td>{{$release->reservation_id}}</td>
                        <td>{{number_format($release->paid)}} @lang("trs.toman")</td>
                        <td>{{number_format($release->total)}} @lang("trs.toman")</td>
                        <td>{{number_format($release->commission)}} @lang("trs.toman")</td>
                        <td>{{jdate($release->created_at)->format('Y-m-d')}}</td>
                        <td>{{number_format($release->balance)}} @lang("trs.toman")</td>
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
