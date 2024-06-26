@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.bank_cards')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.bank_cards_list')</h5>
        <div class="table-responsive text-nowrap">
            @if (count($banks))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>نام بانک</th>
                        <th>شماره کارت</th>
                        <th>شبا</th>
                        <th>تاریخ</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($banks as $bank)
                        <tr>
                            <td data-th="نام بانک">{{ $bank->name }}</td>
                            <td data-th="شماره کارت">{{ $bank->card }}</td>
                            <td data-th="شبا">{{ $bank->shaba }}</td>
                            <td data-th="تاریخ">
                                {{jdate(strtotime($bank->created_at))->format("Y-n-j")}}
                            </td>
                            <td data-th="مدیریت">
                                <ul class="ulinlin fsize13">
                                    <li>
                                        <button style="background:none;border: none;"
                                                onclick='functionConfirm("آیا از حذف کارت اطمینان دارید ؟", function yes() {
                                                    window.location.replace("{{route('carwash_bank_delete',$bank->id)}}");
                                                    },
                                                    function no() {
                                                    });'>حذف
                                        </button>
                                    </li>
                                    <li class="mgright10"><a class="no_hover_a"
                                                             href="{{route('carwash_bank_edit',$bank->id)}}">ویرایش</a>
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
