@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.edit_role')</span>
@endsection

@section('content')
    <div class="row justify-content-center" style="margin-top:5%">
        <div class="col-md-8 cardbank  bankadd" style="">
            <div class="card mb-4"><h5 class="card-header">@lang('trs.edit_role')</h5>
                <form action="{{ route('admin.role.update',$role->id) }}" method="POST">
                    @csrf
                    <div class="card-body demo-vertical-spacing demo-only-element">

                        <div class="row mg-b-10">
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="title">عنوان</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="title" name="title" dir="rtl"
                                           placeholder="" value="{{$role->title}}" required="">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mg-b-10">
                                <label class="form-label" for="name">نام انگلیسی</label>
                                <div class="input-group">
                                    <input type="text" class="form-control text-start" id="name" name="name" dir="ltr"
                                           placeholder="" value="{{$role->name}}" required="">
                                </div>
                            </div>

                            <div class="col-12 mg-b-10">
                                <label class="form-label">دسترسی ها</label>
                                @foreach($permissions as $permission)
                                    <div class="form-check">
                                        <label class="form-label"
                                               for="permission_{{$permission->id}}">{{$permission->title}}</label>
                                        <input class="form-check-input" name="permissions[]" type="checkbox"
                                               value="{{$permission->id}}"
                                               {{in_array($permission->id,$role->permissions()->pluck('permissions.id')->toArray()) ? "checked" : ""}}
                                               id="permission_{{$permission->id}}">
                                    </div>
                                @endforeach

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
