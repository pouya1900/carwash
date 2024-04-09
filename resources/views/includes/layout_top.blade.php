<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token()  }}">
    <title>{{$setting->title}}</title>
    <base href="{{env('APP_URL')}}">
    <link rel="icon" href="{{$setting->icon['path']}}" type="image/gif" sizes="16x16">
    {{--    <script--}}
    {{--        src="storage/js/ae2e33a4ec.js"--}}
    {{--        src="https://kit.fontawesome.com/ae2e33a4ec.js"--}}
    {{--            crossorigin="anonymous"></script>--}}
    <link href="storage/plugins/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="storage/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="storage/plugins/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="storage/plugins/fontawesome/css/solid.min.css" rel="stylesheet">
    <script type="text/javascript" src="storage/js/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet"
          href="storage/css/bootstrap.rtl.min.css"
        {{--          href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css"--}}
    >

    @yield('style')


    <link rel="stylesheet" href="storage/css/style.css">
    <link rel="stylesheet" href="storage/css/media_style.css">

    <script type="text/javascript" src="storage/js/loading.js"></script>
    @vite(['resources/js/app.js'])


</head>
<body class="dark">
