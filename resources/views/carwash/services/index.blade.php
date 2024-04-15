@extends('layouts.carwash')


@section('title')
    <span class="titlescc">@lang('trs.services')</span>
@endsection
@section('content')

    <div class="card ticket">

        <div class="card-body ">

            <table id="example" class="table table-striped" style="width:95%">
                <thead>
                <tr>
                    <th>عنوان</th>
                    <th>توضیحات</th>
                    <th>ایتم ها</th>
                    <th>قیمت</th>
                    <th>تخفیف</th>
                    <th>نوع</th>
                    <th>وضعیت</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($carwash->services()->orderBy("is_main","desc")->orderBy("created_at","desc")->get() as $service)
                    <tr>
                        <td>{{ $service->base->title }}</td>
                        <td>{{ $service->base->descriptionText }}</td>
                        <td>{{ $service->base->itemText }}</td>
                        <td>{{ number_format($service->price) }} تومان</td>
                        <td>{{ $service->discount }}</td>
                        <td>{{ $service->is_main ? "اصلی" : "فرعی" }}</td>
                        <td class="{{\App\Helper::serviceStatusCSS($service->status)}}">{{ \App\Helper::serviceStatus($service->status) }}</td>
                        <td>
                            <ul class="ulinlin fsize13">
                                <li class="mgright10"><a class="no_hover_a"
                                                         href="{{route('carwash_service_edit',$service->id)}}">ویرایش</a>
                                </li>
                                <li>
                                    <button style="background:none;border: none;"
                                            onclick='functionConfirm("آیا از حذف سرویس اطمینان دارید ؟", function yes() {
                                                window.location.replace("{{route('carwash_service_delete',$service->id)}}");
                                                },
                                                function no() {
                                                });'>حذف
                                    </button>
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
