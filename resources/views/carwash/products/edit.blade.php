@extends('layouts.servant')

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
                <form action="{{ route('servant_product_update',$product->id) }}" method="POST"
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

                                <label class="form-label" for="price">قیمت(@lang("trs.rial"))</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start number_format_input" id="price" name="price"
                                           dir="ltr" value="{{$product->price}}"
                                           placeholder="" required="">
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="link">لینک</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="link" name="link" dir="ltr"
                                           placeholder="" value="{{$product->link}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mg-office--item">
                                <label>@lang('trs.product_logo')</label>


                                <div>
                                    <image-input-preview att_name="logo"
                                                         src="{{$product->logo["model"] ? $product->logo["path"] : ""}}">
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

                        <div class="col-12">
                            <div class="mg-office--item">
                                <label>@lang('trs.product_video')</label>


                                <div>
                                    <video-input-preview
                                        src="{{$product->video["model"] ? $product->video["path"] : ""}}">
                                    </video-input-preview>
                                </div>


                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mg-office--item">
                                <label>@lang('trs.product_catalog')</label>
                                <div class="product_catalog--container">

                                    {{--            @if ($office->catalog)--}}

                                    <div class="row">
                                        <div class="col-6 text-right">
                                            <input type="file" name="catalog" accept="application/pdf">
                                        </div>
                                        <div class="col-6">
                                            @if ($product->catalog["model"])
                                                <div class="product_catalog--exist">
                                                    <span><i
                                                            class="fa-solid fa-file-pdf"></i>
                                                        <a href="{{$product->catalog["path"]}}">@lang('trs.download_catalog_submitted_before')</a>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                    </div>

                                    {{--            @else--}}
                                    {{--            @endif--}}
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
