<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\SubmitNotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ticketMessageRequest;
use App\Models\Carwash;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class TicketController extends Controller
{
    public function index($type)
    {
        $admin = $this->request->admin;

        if (!in_array($type, ['user', 'carwash'])) {
            abort(404);
        }

        if ($type == 'user') {
            $tickets = Ticket::where('ticketable_type', User::class)->orderBy("created_at", "desc")->get();
        } else {
            $tickets = Ticket::where('ticketable_type', Carwash::class)->orderBy("created_at", "desc")->get();
        }

        return view('admin.tickets.index', compact('admin', 'tickets', 'type'));

    }

    public function edit(Ticket $ticket)
    {
        $admin = $this->request->admin;

        $ticket->messages()->whereNull("admin_id")->update([
            "admin_id" => $admin->id,
        ]);

        return view('admin.tickets.edit', compact('ticket', 'admin'));
    }

    public function update(Ticket $ticket, ticketMessageRequest $request)
    {
        try {

            $message = $request->input('message');
            $admin = $this->request->admin;

            $ticket->messages()->create([
                'admin_id' => $admin->id,
                'sender'   => 'admin',
                'text'     => $message,
            ]);

            $notification_message = "تیکت پشتیبانی با عنوان" . $ticket->title . " پاسخ داده شد.";

            Event::dispatch(new SubmitNotificationEvent($notification_message, $ticket->ticketable));


            return redirect(route('admin.ticket.edit', $ticket->id));
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.there_is_problem_to_send_message')]);
        }
    }

    public function close(Ticket $ticket)
    {
        try {
            $ticket->update([
                "status" => "closed",
            ]);
            return redirect(route('admin.ticket.edit', $ticket->id))->with("message", trans('trs.ticket_closed_successfully'));
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.there_is_problem_to_close_ticket')]);
        }
    }

}
