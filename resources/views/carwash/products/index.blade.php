@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.products')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.products_list')</h5>
        <div class="table-responsive text-nowrap">
            <table class="table txtcenter" style="width: 95%">
                <thead>
                <tr>
                    <th>@lang('trs.title')</th>
                    <th>@lang('trs.price')</th>
                    <th>@lang('trs.status')</th>
                    <th>@lang('trs.status_message')</th>
                    <th>مدیریت</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($servant->products()->orderBy("created_at","desc")->get() as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ number_format($product->price) }} @lang("trs.rial")</td>
                        <td>
                            @if($product->status == "pending")
                                <span class="btn-label-info">در انتظار تایید</span>
                            @elseif($product->status == "accepted")
                                <span class="btn-label-success">تایید شده</span>
                            @elseif($product->status == "rejected")
                                <span class="btn-label-warning">رد شده</span>
                            @elseif($product->status == "rfd")
                                <span class="btn-label-warning">نیاز به اصلاح</span>
                            @else
                                ---
                            @endif
                        </td>
                        <td>
                            {{$product->status_message}}
                        </td>
                        <td>
                            <ul class="ulinlin fsize13">
                                <li>
                                    <button style="background:none;border: none;"
                                            onclick='functionConfirm("آیا از حذف محصول اطمینان دارید ؟", function yes() {
                                                window.location.replace("{{route('servant_product_delete',$product->id)}}");
                                                },
                                                function no() {
                                                });'>حذف
                                    </button>
                                </li>
                                <li class="mgright10"><a class="no_hover_a"
                                                         href="{{route('servant_product_edit',$product->id)}}">ویرایش</a>
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
