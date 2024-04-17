@extends('layouts.servant')

@section('title')
    <span class="titlescc">@lang('trs.reservation')</span>
@endsection

@section('content')

    <div class="row justify-content-center" id="app" style="margin-top:5%">
        <div class="col-md-10 cardbank  bankadd" style="">
            <div class="card mb-4">
                <h5 class="card-header txtcenter">@lang('trs.reservation')</h5>

                <div class="card-body demo-vertical-spacing demo-only-element">

                    <div class="reservation_information_container">
                        <h5>@lang('trs.reservation_information')</h5>

                        <div class="row">
                            <div class="col-8">
                                <div class="reservation_information_body">
                                    <ul>
                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.services_list')</span>
                                                </div>
                                                <div class="col-9">
                                                    @foreach($reservation->services as $key=>$service)
                                                        @if ($key>0)
                                                            {{"، "}}
                                                        @endif
                                                        {{$service->title}}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.user_name')</span>
                                                </div>
                                                <div class="col-9">
                                                    <span>{{$reservation->user?->fullName}}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.time')</span>
                                                </div>
                                                <div class="col-9">
                                                    {{$reservation->time ?? jdate(strtotime($reservation->time?->start))->format('%A %d %B , H:i')}}
                                                    الی
                                                    {{$reservation->time ?? jdate(strtotime($reservation->time?->end))->format('H:i')}}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.services_type')</span>
                                                </div>
                                                <div class="col-9">
                                                    @foreach($reservation->services()->distinct('type')->pluck('type')->toarray() as $key=>$type)
                                                        @if ($key>0)
                                                            ،
                                                        @endif
                                                        {{\App\Helper::serviceType($type)}}
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        @if ($reservation->insurance)
                                            <li>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <span>@lang('trs.insurance')</span>
                                                    </div>
                                                    <div class="col-9">
                                                        {{$reservation->insurance->title}}
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <span>@lang('trs.insurance_number')</span>
                                                    </div>
                                                    <div class="col-9">
                                                        {{$reservation->insurance_number}}
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <span>@lang('trs.insurance_value')</span>
                                                    </div>
                                                    <div class="col-9">
                                                        {{$reservation->insurance_value}}
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.total_cost')</span>
                                                </div>
                                                <div class="col-9">
                                                    {{number_format($reservation->price)}} @lang("trs.toman")
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-4">

                                @if ($reservation->services()->where('type','home')->first())
                                    <div>
                                        <p class="text-center">مکان کاربر</p>
                                        <show-marker-map
                                            :location="{{json_encode([$reservation->address?->lat,$reservation->address?->long])}}"
                                            :marker_path="{{json_encode(url("/storage/assets/siteContent/marker.png"))}}"></show-marker-map>
                                    </div>

                                    <div>
                                        <get-direction :trs="{{json_encode(trans('trs'))}}"
                                                       :location="{{json_encode([$reservation->address?->lat,$reservation->address?->long])}}">
                                        </get-direction>
                                    </div>

                                @elseif($reservation->services()->where('type','onsite')->first())
                                    <div>
                                        <p class="text-center">مکان خدمت شما</p>
                                        <show-marker-map
                                            :location="{{json_encode([$reservation->address?->lat,$reservation->address?->long])}}"
                                            :marker_path="{{json_encode(url("/storage/assets/siteContent/marker.png"))}}"></show-marker-map>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <ul>
                                    <li>
                                        <div class="row">
                                            <div class="col-3">
                                                <span>@lang('trs.status')</span>
                                            </div>
                                            <div class="col-9">
                                                {{App\Helper::reservationStatusToTranslated($reservation->status)}}
                                            </div>
                                        </div>
                                    </li>

                                    @if ($reservation->status=="requested")

                                        <li class="reservation_system_message">
                                            وضعیت سرویس در انتظار تایید می باشد. پس از مشاهده اطلاعات وضعیت را به
                                            یکی از
                                            حالت
                                            های زیر تغییر دهید. شما می توانید درخواست را بپذیرید , ان را رد کنید و
                                            یا در
                                            صورتی
                                            که برای تصمیم گیری نیاز به اطلاعات بیشتری از طرف کاربر دارید درخواست
                                            اطلاعات
                                            بشتر
                                            کنید. در صورت عدم تغییر وضعیت درخواست کاربر رد و حساب شما تا بررسی
                                            پشتیبانی غیر
                                            فعال
                                            می شود.
                                        </li>

                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.remain_time')</span>
                                                </div>
                                                <div class="col-9">
                                                    <span id="remain_time"></span>
                                                </div>
                                            </div>
                                        </li>
                                        <li id="change_buttons">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('servant_reservation_update_status',['reservation'=>$reservation->id,'status'=>'accepted'])}}"
                                                               class="btn btn-secondary full-width">
                                                                @lang('trs.accept_request')
                                                            </a>
                                                        </div>
                                                        <div class="col-4">
                                                            <button data-bs-toggle="modal"
                                                                    data-bs-target="#rejectModal"
                                                                    class="btn btn-info full-width">
                                                                @lang('trs.need_info_request')
                                                            </button>
                                                        </div>
                                                        <div class="col-4">
                                                            <a href="{{route('servant_reservation_update_status',['reservation'=>$reservation->id,'status'=>'rejected'])}}"
                                                               type="submit" class="btn btn-alarm full-width">
                                                                @lang('trs.reject_request')
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @elseif ($reservation->status=="asked")
                                        <li class="reservation_system_message">
                                            شما درخواست اطلاعات بیشتری از کاربر نموده اید. می توانید از بخش پیام ها
                                            پاسخ
                                            کاربر را مشاهده کرده و سپس وضعیت سرویس را تغییر دهید.
                                        </li>
                                        <li id="change_buttons">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('servant_reservation_update_status',['reservation'=>$reservation->id,'status'=>'accepted'])}}"
                                                               class="btn btn-secondary full-width">
                                                                @lang('trs.accept_request')
                                                            </a>
                                                        </div>
                                                        <div class="col-4">
                                                            <a href="{{route('servant_reservation_update_status',['reservation'=>$reservation->id,'status'=>'rejected'])}}"
                                                               type="submit" class="btn btn-alarm full-width">
                                                                @lang('trs.reject_request')
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @elseif ($reservation->status=="doing")
                                        <li class="reservation_system_message">
                                            پس از پایان کار شما می توانید از گزینه زیر درخواست دهید تا کاربر اتمام سفارش
                                            را تایید کند. در صورتی که کاربر درخواست شکایت ثبت کند یا تا 24 ساعت تایید
                                            نکند پشتیبانی برای تصمیم گیری وارد می شود.
                                        </li>
                                        <li id="change_buttons">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="row justify-content-center">
                                                        <div class="col-8">
                                                            <button class="btn btn-secondary full-width"
                                                                    onclick='functionConfirm("آیا از اتمام سفارش اطمینان دارید ؟", function yes() {
                                                                        window.location.replace("{{route('servant_reservation_update_status',['reservation'=>$reservation->id,'status'=>'done'])}}");
                                                                        },
                                                                        function no() {
                                                                        });'>@lang('trs.request_finish_reservation')
                                                            </button>
                                                            <div id="confirm">
                                                                <div class="message"></div>
                                                                <button class="yes">بله</button>
                                                                <button class="no">خیر</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @elseif ($reservation->status=="done")
                                        <li class="reservation_system_message">
                                            شما درخواست اتمام سفارش داده اید. کاربر 24 ساعت برای تغییر وضعیت فرصت دارد.
                                            در صورتی که کاربر درخواست شکایت ثبت کند یا تا 24 ساعت اتمام سفارش را تایید
                                            نکند پشتیبانی برای تصمیم گیری وارد می شود.
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-3">
                                                    <span>@lang('trs.remain_time')</span>
                                                </div>
                                                <div class="col-9">
                                                    <span id="remain_time_finish"></span>
                                                </div>
                                            </div>
                                        </li>

                                    @endif
                                </ul>

                            </div>
                        </div>

                        <div class="reservation_part_container" role="tablist">
                            <div class="reservation_part_tabs">
                                <div class="reservation_tab active" data-bs-toggle="tab" role="tab"
                                     aria-controls="chat"
                                     data-bs-target="#chat"
                                     id="chat_tab">
                                    <span>@lang('trs.chat')</span>
                                </div>
                                <div class="reservation_tab" data-bs-toggle="tab" role="tab"
                                     aria-controls="follow"
                                     data-bs-target="#follow"
                                     id="follow_tab">
                                    <span>@lang('trs.follow_up')</span>
                                </div>
                                <div class="reservation_tab" data-bs-toggle="tab" role="tab"
                                     aria-controls="document"
                                     data-bs-target="#document"
                                     id="document_tab">
                                    <span>@lang('trs.documents')</span>
                                </div>
                                <div class="reservation_tab" data-bs-toggle="tab" role="tab"
                                     aria-controls="video_chat"
                                     data-bs-target="#video_chat"
                                     id="video_chat_tab">
                                    <span>@lang('trs.video_chat')</span>
                                </div>

                            </div>

                            <div class="reservation_part_panes">
                                <div class="reservation_pane tab-pane fade active show" role="tabpanel" id="chat"
                                     aria-labelledby="chat_tab">

                                    <div>
                                        <message :trs="{{json_encode(trans('trs'))}}"
                                                 :csrf="{{json_encode(csrf_token())}}"
                                                 :side="{{json_encode('servant')}}"
                                                 :send_message_url="{{json_encode(route('servant_reservation_new_message',$reservation->id))}}"
                                                 :get_messages_url="{{json_encode(route('servant_reservation_messages',$reservation->id))}}"
                                                 :messages="{{json_encode($reservation->messages)}}">
                                        </message>
                                    </div>

                                </div>

                                <div class="reservation_pane tab-pane fade" role="tabpanel" id="follow"
                                     aria-labelledby="follow_tab">

                                    @foreach($reservation->guarantees as $key=>$guarantee)
                                        <input type="hidden" name="guar[{{$key}}]" value="{{$guarantee->id}}">
                                        <div class="guarantee_container">
                                            <div class="servant_guar_message">
                                                <span>{{$guarantee->servant_message}}</span>
                                                <span class="servant_guar_message_delete"><a
                                                        href="{{route('servant_reservation_delete_guarantee',$guarantee->id)}}">حذف</a> </span>
                                            </div>
                                            <div class="user_guar_message">
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               {{$guarantee->user_check ? "checked" : ""}} readonly
                                                               disabled>
                                                        <label class="form-check-label">
                                                            <span class="res_lab_title">انجام شده است؟</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="form-label"
                                                           for="guar_user_message{{$key}}">پیام کاربر:</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control text-start"
                                                               value="{{$guarantee->user_message}}"
                                                               readonly disabled
                                                               placeholder="">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <form method="post"
                                          action="{{route('servant_reservation_update_guarantee',$reservation->id)}}">
                                        {{csrf_field()}}

                                        <div class="new_guarantee_container">
                                            <div>
                                                <h6>افزودن پیگیری جدید</h6>
                                                <label class="form-label"
                                                       for="new_guarantee">متن دستور : </label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control text-start"
                                                           id="new_guarantee" name="new_guarantee" placeholder="">
                                                </div>

                                            </div>
                                            <div class="demo-vertical-spacing">
                                                <button type="submit" class="btn btn-secondary half-width">
                                                    @lang('trs.submit')
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="reservation_pane tab-pane fade" role="tabpanel" id="document"
                                     aria-labelledby="document_tab">
                                    <div>
                                        <div>
                                            <p>@lang('trs.new_document')</p>

                                            <form method="post" enctype="multipart/form-data"
                                                  action="{{route('servant_reservation_store_record',$reservation->id)}}">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-12 col-lg-5">
                                                        <label class="form-label"
                                                               for="document_title">نام پرونده : </label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control text-start"
                                                                   id="document_title" name="document_title"
                                                                   placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-5">
                                                        <label class="form-label"
                                                               for="document_file">فایل پرونده : </label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control text-start"
                                                                   id="document_file" name="document_file"
                                                                   placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-2">
                                                        <div class="form-check">
                                                            <label class="form-label"
                                                                   for="private">@lang("trs.user_cant_see_document")</label>
                                                            <input class="form-check-input" name="private"
                                                                   type="checkbox" id="private">
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="demo-vertical-spacing">
                                                            <button type="submit" class="btn btn-secondary full-width">
                                                                @lang('trs.submit')
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="table-responsive text-nowrap">
                                            @if ($reservation->records->isNotEmpty())

                                                <table class="table txtcenter" style="width: 95%">
                                                    <thead>
                                                    <tr>
                                                        <th>عنوان</th>
                                                        <th>فایل</th>
                                                        <th>تاریخ</th>
                                                        <th>مدیریت</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                    @foreach($reservation->records as $record)
                                                        <tr>
                                                            <td>{{ $record->title }}</td>
                                                            <td><a href="{{$record->file["path"]}}"
                                                                   target="_blank">دانلود</a>
                                                            </td>
                                                            <td>
                                                                {{jdate(strtotime($record->created_at))->format("Y-n-j")}}
                                                            </td>
                                                            <td>
                                                                <ul class="ulinlin fsize13">
                                                                    <li>
                                                                        <button style="background:none;border: none;"
                                                                                onclick='functionConfirm("آیا از حذف پرونده اطمینان دارید ؟", function yes() {
                                                                                    window.location.replace({{route('servant_reservation_delete_record',$record->id)}});
                                                                                    },
                                                                                    function no() {
                                                                                    });'>حذف
                                                                        </button>
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
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="reservation_pane tab-pane fade" role="tabpanel" id="video_chat"
                                     aria-labelledby="video_chat_tab">

                                    <div>
                                        <video-chat
                                            :receiver="{{json_encode($reservation->user)}}"
                                            :sender="{{json_encode($servant)}}"
                                            :csrf="{{json_encode(csrf_token())}}"
                                            :video_chat_url="{{json_encode(route('servant_reservation_video_chat',$reservation->id))}}"
                                            pusher-key="{{ config('broadcasting.connections.pusher.key') }}"
                                            pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}">
                                        </video-chat>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1"
         aria-labelledby="rejectModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    <div class="modal-title text-center mb-4"><h4
                            class="mb-4 secondary-font">درخواست اطلاعات بیشتر</h4></div>
                    <form method="get"
                          action="{{route('servant_reservation_update_status',['reservation'=>$reservation->id,'status'=>'asked'])}}">
                        <div class="mg-b-10">
                            <label class="form-label"
                                   for="reject_message">پیام به کاربر:</label>
                            <div class="input-group">
                                <input type="text" class="form-control text-start" id="reject_message"
                                       name="reject_message"
                                       placeholder="">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-secondary full-width">
                            @lang('trs.submit')
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </div>
    <div id="confirm">
        <div class="message"></div>
        <button class="yes">بله</button>
        <button class="no">خیر</button>
    </div>

@endsection

@section('script')

    <script>
        import VideoChat from "../../../js/components/videoChat.vue";
        import Direction from "../../../js/components/direction.vue";

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

        export default {
            components: {Direction, VideoChat}
        }
    </script>
    @if ($reservation->status=="requested")
        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("{{$reservation->created_at}}").getTime();

            // Update the count down every 1 second
            var x = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = 30 * 1000 * 60 - now + countDownDate;

                // Time calculations for days, hours, minutes and seconds
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                document.getElementById("remain_time").innerHTML = minutes + ":" + seconds;

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("remain_time").innerHTML = "زمان پذیرش تمام شده است.";
                    document.getElementById("change_buttons").innerHTML = "";
                }
            }, 1000);
        </script>
    @elseif ($reservation->status=="done")
        <script>
            // Set the date we're counting down to
            var countDownDate = new Date("{{$reservation->servant_change_date}}").getTime();

            // Update the count down every 1 second
            var x = setInterval(function () {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = 60 * 24 * 1000 * 60 - now + countDownDate;

                // Time calculations for days, hours, minutes and seconds
                var hour = Math.floor((distance % (1000 * 60 * 60 * 60)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                document.getElementById("remain_time_finish").innerHTML = hour + ":" + minutes + ":" + seconds;

                // If the count down is over, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("remain_time_finish").innerHTML = "زمان اتمام سفارش تمام شده است.";
                }
            }, 1000);
        </script>
    @endif
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

