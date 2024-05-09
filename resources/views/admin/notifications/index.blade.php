@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.notifications')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.notifications')</h5>
        <div class="table-responsive text-nowrap">
            @if (count($notifications))
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
                            <td data-th="@lang('trs.title')"><p
                                    class="notification_title">{{ $notification->title }}</p></td>
                            <td data-th="@lang('trs.time')">{{ jdate($notification->created_at)->format("Y-m-d H:i") }}</td>
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
