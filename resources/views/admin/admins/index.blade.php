@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.admins')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.admins_list')</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام</th>
                    <th>موبایل</th>
                    <th>نقش</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($administrators as $key=>$administrator)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $administrator->fullName }}</td>
                        <td>{{ $administrator->mobile }}</td>
                        <td>{{ $administrator->role?->title }}</td>
                        <td>
                            <ul class="ulinlin fsize13">
                                <li>
                                    <button style="background:none;border: none;"
                                            onclick='functionConfirm("آیا از حذف مدیر اطمینان دارید ؟", function yes() {
                                                window.location.replace("{{route('admin.admin.remove',$administrator->id)}}");
                                                },
                                                function no() {
                                                });'>حذف
                                    </button>
                                </li>
                                <li class="mgright10"><a class="no_hover_a"
                                                         href="{{route('admin.admin.edit',$administrator->id)}}">ویرایش</a>
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
