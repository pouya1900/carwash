<?php

namespace App\Http\Controllers\Servant;

use App\Events\SubmitNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Guarantee;
use App\Models\Record;
use App\Models\Servant;
use App\Models\Reservation;
use App\Traits\UploadUtilsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Pusher\Pusher;
use function Symfony\Component\String\b;

class ReservationController extends Controller
{
    use UploadUtilsTrait;

    public function index()
    {
        $servant = $this->request->current_servant;
        $reservations = $servant->reservations()->orderBy("created_at", "desc")->get();

        return view('servant.reservations.index', compact('servant', 'reservations'));
    }

    public function show(Reservation $reservation)
    {
        $servant = $this->request->current_servant;

        if ($reservation->servant->id != $servant->id) {
            abort(403);
        }

        return view('servant.reservations.show', compact('servant', 'reservation'));
    }

    public function new_message(Reservation $reservation)
    {
        try {
            $servant = $this->request->current_servant;

            if ($reservation->servant->id != $servant->id) {
                abort(403);
            }

            $message = $this->request->input('message');

            $new_message = $reservation->messages()->create([
                'sender' => 'servant',
                'text'   => $message,
            ]);

            return response()->json(['status' => 0, 'messages' => $new_message]);
        } catch (\Exception) {
            return response()->json(['status' => 1]);
        }
    }

    public function get_messages(Reservation $reservation)
    {
        $servant = $this->request->current_servant;

        if ($reservation->servant->id != $servant->id) {
            abort(403);
        }


        $messages = $reservation->messages()->whereNull('seen_at')->where('sender', 'user')->get();

        foreach ($messages as $message) {
            $message->update([
                'seen_at' => Carbon::now(),
            ]);
        }

        return response()->json(['status' => 0, 'messages' => $messages]);

    }

    public function store_guarantee(Reservation $reservation)
    {
        try {
            $servant = $this->request->current_servant;

            if ($reservation->servant->id != $servant->id) {
                abort(403);
            }

            $guarantee = $reservation->guarantees()->create([
                'servant_message' => $this->request->input('new_guarantee'),
                'user_check'      => 0,
            ]);
            return redirect(route('servant_reservation_show', $reservation->id))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function delete_guarantee(Guarantee $guarantee)
    {
        try {

            $servant = $this->request->current_servant;

            if ($guarantee->reservation->servant->id != $servant->id) {
                abort(403);
            }

            $guarantee->delete();

            return redirect(route('servant_reservation_show', $guarantee->reservation->id))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }

    }

    public function store_record(Reservation $reservation)
    {
        try {
            $servant = $this->request->current_servant;

            if ($reservation->servant->id != $servant->id) {
                abort(403);
            }

            $title = $this->request->input('document_title');
            $file = $this->request->file('document_file');
            $private = $this->request->input('private');

            $record = $reservation->records()->create([
                "title"   => $title,
                "private" => $private ? 1 : 0,
            ]);

            $media = $this->documentUpload($file, 'record', 'privateStorage', $record);

            return redirect()->back()->with(['message' => trans('trs.document_saved_successfully')]);

        } catch (\Exception) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }


    }

    public function delete_record(Record $record)
    {
        try {
            $servant = $this->request->current_servant;

            if ($record->reservation->servant->id != $servant->id) {
                abort(403);
            }


            $record->delete();
            return redirect()->back()->with(['message' => trans('trs.changed_successfully')]);

        } catch (\Exception) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

    public function video_chat()
    {
        $servant = $this->request->current_servant;
        $socket_id = $this->request->socket_id;
        $channel_name = $this->request->channel_name;
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            [
                'cluster'   => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true,
            ]
        );
        return response(
            $pusher->presence_auth($channel_name, $socket_id, $servant->id)
        );

    }

    public function update_status(Reservation $reservation, $status)
    {
        try {
            $servant = $this->request->current_servant;

            if ($reservation->servant->id != $servant->id) {
                abort(403);
            }
            if ($status != "accepted" && $status != "rejected" && $status != "asked" && $status != "done") {
                abort(404);
            }

            if ($status == "done" && $reservation->status != "doing") {
                abort(404);
            }

            $reservation->update([
                'status'              => $status,
                'servant_change_date' => Carbon::now(),
            ]);

            if ($status == "asked") {
                $message = $this->request->input('reject_message');

                $new_message = $reservation->messages()->create([
                    'sender' => 'servant',
                    'text'   => $message,
                ]);
            }

            if ($status == "accepted") {
                $notification_message = "درخواست خدمات شما از طرف " . $servant->fullName . " پذیرفته شده است. لطفا ظرف مدت 30 دقیقه اقدام به پرداخت فاکتور نمایید.";
            } else if ($status == "rejected") {
                $notification_message = "درخواست خدمات شما از طرف " . $servant->fullName . " رد شده است.";
            } else if ($status == "asked") {
                $notification_message = "درخواست شما توسط خدمت دهنده " . $servant->fullName . "بررسی شده است و خدمت دهنده درخواست اطلاعات بیشتری برای قبول خدمت کرده است. لطفا از بخش پیام ها در صفحه سفارش مورد نظر ، پیام خدمت دهنده را مشاهده فرموده و پاسخ دهید";
            } else {
                $text = "";
                foreach ($reservation->services as $key => $service) {
                    $text .= $service->title;
                    if ($key + 1 < $reservation->services->count()) {
                        $text .= "،";
                    }
                }
                $notification_message = "خدمت دهنده درخواست پایان سفارش و ازادسازی مبلغ را برای سفارش " . $text . " داده است. لطفا در صورتی که خدمات مورد نظر را با موفقیت دریافت کرده اید اقدام به قبول درخواست و امتیاز دهی به خدمت دهنده نمایید.";
            }

            Event::dispatch(new SubmitNotificationEvent($notification_message, $reservation->user, 1));


            return redirect(route('servant_reservation_show', $reservation->id))->with(['message' => trans('trs.changed_successfully')]);
        } catch (\Exception) {
            return redirect()->back()->withErrors('error', trans('trs.changed_unsuccessfully'));
        }
    }

}
