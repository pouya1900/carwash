@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.user')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.all_users')</h5>
        <div class="table-responsive text-nowrap">
            @if (count($users))
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
                    @foreach($users as $user)
                        <tr>
                            <td data-th="نام">{{ $user->fullName }}</td>
                            <td data-th="موبایل">{{ $user->mobile }}</td>
                            <td data-th="موجودی">{{ number_format($user->balance) }}</td>
                            <td data-th="وضعیت">{{ \App\Helper::turn_user_status($user->status) }}</td>
                            <td data-th="مدیریت">
                                <ul class="ulinlin fsize13">
                                    {{--                                <li>--}}
                                    {{--                                    <button style="background:none;border: none;"--}}
                                    {{--                                            onclick='functionConfirm("آیا از بلاک کردن کاربر اطمینان دارید ؟", function yes() {--}}
                                    {{--                                                window.location.replace("{{route('admin.user.block',$user->id)}}");--}}
                                    {{--                                                },--}}
                                    {{--                                                function no() {--}}
                                    {{--                                                });'>حذف--}}
                                    {{--                                    </button>--}}
                                    {{--                                </li>--}}
                                    <li class="mgright10"><a class="no_hover_a"
                                                             href="{{route('admin.user.edit',$user->id)}}">ویرایش</a>
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
