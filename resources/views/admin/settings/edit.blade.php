@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.settings')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.settings')</h5>
                <form action="{{ route('admin.settings.update') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="row mg-b-10" id="app">
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="title">عنوان سایت</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="title" name="title"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$setting->title}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="email">ایمیل شرکت</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="email" name="email"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$setting->email}}">
                                </div>
                            </div>

                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="address">ادرس شرکت</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="address" name="address"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$setting->address}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="phone">تلفن شرکت</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="phone" name="phone"
                                           dir="rtl"
                                           placeholder="" required="" value="{{$setting->phone}}">
                                </div>
                            </div>

                            <div class="col-12 mg-b-10">
                                <label class="form-label">تصویر لوگو سایت</label>
                                <image-input-preview att_name="logo"
                                                     src="{{$setting->logo["model"] ? $setting->logo["path"] : ""}}">
                                </image-input-preview>
                            </div>

                            <div class="col-12 mg-b-10">
                                <label class="form-label">تصویر ایکون سایت</label>
                                <image-input-preview att_name="icon"
                                                     src="{{$setting->icon["model"] ? $setting->icon["path"] : ""}}">
                                </image-input-preview>
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

    <script src="https://cdn.tiny.cloud/1/lspn926evhqnjbunloefdwuyjkll6j9q085tshnm9uhpaexi/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#about',
            height: 300,
            width: "100%",
            menubar: false,
            skin: 'oxide',
            content_css: '',
            plugins: [
                'advlist ', 'directionality', 'autolink', ' lists', 'link', 'image', 'charmap', 'print', 'preview', 'anchor', 'textcolor',
                'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'contextmenu', 'paste', 'code', 'help'

            ],
            toolbar1: ' styleselect | fontselect | fontsizeselect | searchreplace insertdatetime charmap | bold italic underline strikethrough subscript superscript | alignleft aligncenter alignright alignjustify ltr rtl |  bullist numlist | forecolor backcolor | blockquote link unlink table | image media  | code preview ',
            image_advtab: true,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],

            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,


        });

    </script>

@endsection
