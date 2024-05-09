@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.products')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.products_list')</h5>
        <div class="table-responsive text-nowrap">
            @if (count($carwash->products()->orderBy("created_at","desc")->get()))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>@lang('trs.title')</th>
                        <th>@lang('trs.category')</th>
                        <th>@lang('trs.price')</th>
                        <th>@lang('trs.discount')</th>
                        <th>مدیریت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($carwash->products()->orderBy("created_at","desc")->get() as $product)
                        <tr>
                            <td data-th="@lang('trs.title')">{{ $product->title }}</td>
                            <td data-th="@lang('trs.category')">{{ $product->category->title }}</td>
                            <td data-th="@lang('trs.price')">{{ number_format($product->price) }} @lang("trs.toman")</td>
                            <td data-th="@lang('trs.discount')">{{$product->discount}}</td>
                            <td data-th="مدیریت">
                                <ul class="ulinlin fsize13">
                                    <li>
                                        <button style="background:none;border: none;"
                                                onclick='functionConfirm("آیا از حذف محصول اطمینان دارید ؟", function yes() {
                                                    window.location.replace("{{route('carwash_product_delete',$product->id)}}");
                                                    },
                                                    function no() {
                                                    });'>حذف
                                        </button>
                                    </li>
                                    <li class="mgright10"><a class="no_hover_a"
                                                             href="{{route('carwash_product_edit',$product->id)}}">ویرایش</a>
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
