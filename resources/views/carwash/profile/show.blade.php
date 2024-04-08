@extends('layouts.servant')

@section('style')
    <link href="storage/css/nanogallery2.min.css" rel="stylesheet">
@endsection


@section('title')
    <span class="titlescc">داشبورد من</span>
@endsection

@section('content')

    <div class="card">

        <div class="card-body ">
            <div class="profile_main">
                <div class="profile_main_content">

                    <div class="row justify-content-around">
                        <div class="col-12 col-lg-6">
                            <div class="row">
                                <div class="col-3">
                                    <div class="profile_main--avatar">
                                        <img src="{{$servant->avatar['path']}}" title="" alt="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="profile_main--name">
                                        <p>{{$servant->fullName}}</p>
                                    </div>
                                    <div class="profile_main--about">
                                        <p class="about_text">{{$servant->title}}</p>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <p>{{$servant->mobile}}</p>
                                    <p>{{$servant->email}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            @if ($servant->is_place)
                                <i title="@lang('trs.place')"
                                   class="fa-solid fa-hospital"></i> @lang("trs.place")
                            @endif
                        </div>

                    </div>
                    <div class="row justify-content-around">
                        <div class="col-4 text-center">
                            <a href="{{route('servant_edit')}}" class="edit_profile_button">
                                ویرایش پروفایل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6>متن درباره ما</h6>
            <form action="{{route('servant_about_update')}}" method="post">
                @csrf
                <div class="mg-b-10">
                    <label class="form-label" for="about" style="margin-bottom: 10px;">متن
                    </label>
                    <div class="input-group">
                        <textarea name="about" class="form-control" id="about"
                                  rows="3">{{$servant->about}}
                        </textarea>
                    </div>
                </div>
                <div class="row justify-content-around add_servant_content">
                    <div class="col-4 text-center">
                        <button type="submit"
                                class="btn btn-secondary full-width">
                            @lang('trs.submit')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h6>تصاویر اسلایدر پروفایل</h6>
            <form action="{{route('servant_slideshow_update')}}" method="post">
                @csrf
                <div class="mg-b-10">
                    <div id="app">
                        <upload-media
                            server="{{route('tmp_upload')}}"
                            location="{{$servant->slideshowPath}}"
                            :style="{{json_encode(["backgroundColor"=>"var(--color2)"])}}"
                            :media="{{json_encode($servant->slideshowName)}}">
                        </upload-media>
                    </div>
                </div>
                <div class="row justify-content-around add_servant_content">
                    <div class="col-4 text-center">
                        <button type="submit"
                                class="btn btn-secondary full-width">
                            @lang('trs.submit')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="profile_post_container">

                <div class="row justify-content-around add_servant_content">
                    <div class="col-4 text-center">
                        <a href="{{route('servant_create_content')}}"
                           class="btn btn-secondary full-width">
                            افزودن محتوا
                        </a>
                    </div>
                </div>

                <div id="my_nanogallery2" data-nanogallery2>
                    @foreach($servant->contents as $content)
                        <a href="{{$content['path']}}"
                           data-ngthumb="{{$content['path']}}">{{$content['model']->title_fa}}</a>
                    @endforeach
                </div>

            </div>

        </div>
    </div>



@endsection

@section('script')
    <script type="text/javascript" src="storage/js/jquery.nanogallery2.min.js"></script>

    <script>
        $("#my_nanogallery2").nanogallery2({
            "thumbnailHeight": 300,
            "thumbnailWidth": 'auto',
            galleryTheme: {
                thumbnail: {borderRadius: '15px'},
            },
            thumbnailLabel: {valign: 'middle'},

        });
    </script>

    <script src="https://cdn.tiny.cloud/1/lspn926evhqnjbunloefdwuyjkll6j9q085tshnm9uhpaexi/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#about',
            height: 300,
            width: "100%",
            menubar: false,
            skin: 'oxide-dark',
            content_css: 'dark',
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
