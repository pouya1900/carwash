@extends('layouts.carwash')

@section('style')
    <style>
        .mu-container {
            background: var(--color2) !important;
        }

    </style>
@endsection

@section('title')
    <span class="titlescc">@lang('trs.update_product')</span>
@endsection
@section('content')

    <div class="row justify-content-center" id="app" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.update_product')</h5>
                <form action="{{ route('carwash_product_update',$product->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="">
                            <label class="form-label" for="title">عنوان</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="title" name="title" dir="rtl"
                                       placeholder="" required="" value="{{$product->title}}">
                            </div>
                        </div>
                        <div class="">
                            <label class="form-label" for="description">توضیحات</label>
                            <div class="input-group">
                                <textarea class="form-control text-start" id="description" name="description"
                                          dir="rtl">{{$product->description}}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">

                                <label class="form-label" for="price">قیمت(@lang("trs.toman"))</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start number_format_input" id="price"
                                           name="price"
                                           dir="ltr" value="{{$product->price}}"
                                           placeholder="" required="">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="discount">@lang("trs.discount")</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start number_format_input" id="discount"
                                           name="discount" dir="ltr" value="{{$product->discount}}"
                                           placeholder="@lang("trs.discount")">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="category"
                                       style="margin-bottom: 10px;">@lang('trs.category')</label>
                                <div class="input-group">
                                    <select class="form-control boxaitradeselect" name="category"
                                            id="category">
                                        <option value="">انتخاب دسته بندی...</option>
                                        @foreach($categories as $category)
                                            <option
                                                {{$category->id==$product->category->id ? "selected" : ""}} value="{{$category->id}}">{{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="mg-office--item">
                                <label>@lang('trs.product_logo')</label>
                                <div>
                                    <image-input-preview att_name="logo"
                                                         src="{{$product->logo["model"] ? $product->logo["paths"]["standard"] : ""}}">
                                    </image-input-preview>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mg-office--item">
                                <label>@lang('trs.product_images')</label>
                                <span
                                    class="mg-office--item--product_image_hint">(@lang('trs.product_image_default_size'))</span>

                                <div>
                                    <upload-media
                                        server="{{route('tmp_upload')}}"
                                        location="{{$product->imagesPath}}"
                                        :style="{{json_encode(["backgroundColor"=>"var(--color2)"])}}"
                                        :media="{{json_encode($product->imagesName)}}">
                                    </upload-media>
                                </div>


                            </div>
                        </div>

                        <button type="submit" class="btn btn-secondary full-width">
                            @lang('trs.submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection
