@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.financial')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.releases')</h5>
        <div class="table-responsive text-nowrap">
            @if ($carwash)
                <p>خدمت دهنده : {{$carwash->fullName}}</p>
            @endif
            @if (count($releases))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>ردیف</th>
                        <th>سفارش</th>
                        <th>کارواش</th>
                        <th>دریافتی خدمت دهنده</th>
                        <th>مبلغ کل</th>
                        <th>کارمزد</th>
                        <th>تاریخ</th>
                        <th>موجودی خدمت دهنده</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($releases as $key=>$release)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$release->reservation?->id}}</td>
                            <td>{{$release->carwash?->fullName}}</td>
                            <td>{{number_format($release->paid)}}</td>
                            <td>{{number_format($release->total)}} @lang("trs.toman")</td>
                            <td>{{number_format($release->commission)}}</td>
                            <td>{{jdate($release->created_at)->format('Y-m-d')}}</td>
                            <td>{{number_format($release->balance)}}</td>
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
