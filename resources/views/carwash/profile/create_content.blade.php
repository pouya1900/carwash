@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.add_new_media')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.add_new_media')</h5>
                <form action="{{ route('servant_store_content') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="">
                            <label class="form-label" for="title">عنوان</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="title" name="title" dir="rtl"
                                       placeholder="" required="">
                            </div>
                        </div>

                        <div class="">
                            <label class="form-label" for="file">عکس یا ویدیو</label>
                            <div class="input-group">
                                <input type="file" class="form-control" id="file" name="file"
                                       required="">
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
