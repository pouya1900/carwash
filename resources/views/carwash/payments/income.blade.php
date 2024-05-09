@extends('layouts.carwash')

@section('title')
    <span class="titlescc">مالی</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">لیست درامد ها</h5>
        <div class="table-responsive text-nowrap">
            @if (count($carwash->releases()->orderBy("created_at","desc")->get()))
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
                            <td data-th="سفارش">{{$release->reservation_id}}</td>
                            <td data-th="دریافتی شما">{{number_format($release->paid)}} @lang("trs.toman")</td>
                            <td data-th="مبلغ کل">{{number_format($release->total)}} @lang("trs.toman")</td>
                            <td data-th="کارمزد">{{number_format($release->commission)}} @lang("trs.toman")</td>
                            <td data-th="تاریخ">{{jdate($release->created_at)->format('Y-m-d')}}</td>
                            <td data-th="موجودی">{{number_format($release->balance)}} @lang("trs.toman")</td>
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
