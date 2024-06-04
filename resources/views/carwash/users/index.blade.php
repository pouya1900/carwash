@extends('layouts.carwash')

@section('title')
    <span class="titlescc">@lang('trs.users')</span>
@endsection

@section('content')
    <div class="card ticket">
        <h5 class="card-header">لیست کاربران اطراف تا شعاع {{$radius}} کیلومتری</h5>
        <div class="table-responsive text-nowrap">
            @if (count($users))
                <table class="table txtcenter" style="width: 95%">
                    <thead>
                    <tr>
                        <th>نام</th>
                        <th>فاصله</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($users as $user)
                        <tr>
                            <td data-th="نام">{{ $user->fullName }}</td>
                            <td data-th="فاصله">{{ \App\Helper::getDistance($user->lat,$user->long,$carwash->lat,$carwash->long) }}</td>
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
        <div class="container">
            <form method="get" action="{{route("carwash_users")}}">

                <div class="row">
                    <div class="col-6 mg-b-10">
                        <label class="form-label" for="radius">شعاع جست و جو</label>
                        <div class="input-group">
                            <input type="text" id="radius" class="form-control text-start" name="radius"
                                   dir="ltr" value="{{$radius}}"
                                   placeholder="" required="">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-secondary half-width">جست و جو</button>
                    </div>
                </div>

            </form>
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
