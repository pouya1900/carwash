@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.notifications')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.notifications')</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>@lang('trs.title')</th>
                    <th>@lang('trs.time')</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($notifications as $notification)
                    <tr>
                        <td><p class="notification_title">{{ $notification->title }}</p></td>
                        <td>{{ jdate($notification->created_at)->format("Y-m-d H:i") }}</td>
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
