@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.products')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">@lang('trs.products_list')</h5>

        @if ($carwash)
            <p>کارواش : {{$carwash->title}}</p>
            <p><a class="btn btn-secondary add_button_admin"
                  href="{{route('admin.product.create',$carwash->id)}}">@lang('trs.add_new_product')</a></p>
        @endif

        <div class="table-responsive text-nowrap">
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
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->category?->title }}</td>
                        <td>{{ number_format($product->price) }} @lang("trs.toman")</td>
                        <td>{{$product->discount}}</td>
                        <td>
                            <ul class="ulinlin fsize13">
                                <li>
                                    <button style="background:none;border: none;"
                                            onclick='functionConfirm("آیا از حذف محصول اطمینان دارید ؟", function yes() {
                                                window.location.replace("{{route('admin.product.delete',$product->id)}}");
                                                },
                                                function no() {
                                                });'>حذف
                                    </button>
                                </li>
                                <li class="mgright10"><a class="no_hover_a"
                                                         href="{{route('admin.product.edit',$product->id)}}">ویرایش</a>
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
