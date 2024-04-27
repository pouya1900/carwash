@extends('layouts.admin')

@section('title')
    <span class="titlescc">@lang('trs.ticket')</span>
@endsection
@section('content')

    <div class="row justify-content-center" style="margin-top:5%">

        <div class="col-xl-10 bankadd">
            <div class="card">
                <div class="card-body ">
                    <div class="mg-b-10">
                        <h6>{{$ticket->ticketable->fullName}}</h6>
                    </div>
                    <ul class="timeline timeline-dashed mt-4">
                        <li class="timeline-item timeline-item-primary mb-4">
                            <span class="timeline-indicator timeline-indicator-danger">
                               <i class="fa-regular fa-paper-plane"></i>
                            </span>
                            <div class="timeline-event">
                                <div class="timeline-header border-bottom mb-3">
                                    <h6 class="mb-2">{{ $ticket->title }}</h6>
                                    <small class="left-to-right">
                                        {{jdate(strtotime($ticket->created_at))->format('Y-n-j G:i')}}
                                    </small>
                                </div>
                            </div>
                        </li>
                        @foreach($ticket->messages as $message)

                            @if($message->sender == 'admin')
                                <li class="timeline-item timeline-item-info mb-4">
                                    <span class="timeline-indicator timeline-indicator-info">
                                        <i class="fa-solid fa-headset"></i>
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-sm-0 mb-3">
                                            <small class="left-to-right">
                                                {{jdate(strtotime($message->created_at))->format('Y-n-j G:i')}}

                                            </small>
                                        </div>
                                        <p>{{ $message->text }}</p>
                                    </div>
                                </li>
                            @else
                                <li class="timeline-item timeline-item-danger mb-4">
                                    <span class="timeline-indicator timeline-indicator-danger">
                                        <i class="fa-regular fa-user"></i>
                                    </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-sm-0 mb-3">
                                            <small class="left-to-right">
                                                {{jdate(strtotime($message->created_at))->format('Y-n-j G:i')}}

                                            </small>
                                        </div>
                                        <p>{{ $message->text }}</p>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    @if($ticket->status != "closed")
                        <div style="width: 92%;margin-right: 8%;">
                            <form action="{{ route('admin.ticket.update',$ticket->id) }}" method="POST">
                                @csrf
                                <label class="form-label" for="message">متن پیام </label>
                                <div class="input-group">
                                <textarea id="message" style="text-align:right" name="message" class="form-control"
                                          rows="5" placeholder=""></textarea>
                                </div>
                                <div class="demo-vertical-spacing">
                                    <button type="submit" class="btn btn-secondary full-width">
                                        @lang('trs.send')
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')

@endsection
