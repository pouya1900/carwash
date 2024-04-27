@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.carwash')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.all_carwashes')</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>نام</th>
                    <th>موبایل</th>
                    <th>موجودی</th>
                    <th>وضعیت</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($carwashes as $carwash)
                    <tr>
                        <td>{{ $carwash->title }}</td>
                        <td>{{ $carwash->mobile }}</td>
                        <td>{{ number_format($carwash->balance) }}</td>
                        <td>{{ \App\Helper::turn_carwash_status($carwash->status) }}</td>

                        <td>
                            <ul class="ulinlin fsize13">
                                {{--                                <li>--}}
                                {{--                                    <button style="background:none;border: none;"--}}
                                {{--                                            onclick='functionConfirm("آیا از بلاک کردن کاربر اطمینان دارید ؟", function yes() {--}}
                                {{--                                                window.location.replace("{{route('admin.carwash.block',$carwash->id)}}");--}}
                                {{--                                                },--}}
                                {{--                                                function no() {--}}
                                {{--                                                });'>حذف--}}
                                {{--                                    </button>--}}
                                {{--                                </li>--}}
                                <li class="mgright10"><a class="no_hover_a"
                                                         href="{{route('admin.carwash.edit',$carwash->id)}}">ویرایش</a>
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
