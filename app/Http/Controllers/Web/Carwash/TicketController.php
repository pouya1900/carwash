<?php

namespace App\Http\Controllers\Web\Carwash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ticketMessageRequest;
use App\Http\Requests\Web\ticketStoreRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $carwash = $this->request->current_carwash;

        $tickets = $carwash->tickets()->orderBy("created_at", "desc")->get();

        return view('carwash.tickets.index', compact('tickets', 'carwash'));
    }

    public function create()
    {
        $carwash = $this->request->current_carwash;

        return view('carwash.tickets.create', compact('carwash'));
    }

    public function store(ticketStoreRequest $request)
    {
        try {
            $title = $request->input('title');
            $message = $request->input('message');
            $carwash = $this->request->current_carwash;

            $ticket = $carwash->tickets()->create([
                'title'  => $title,
                'status' => "pending",
            ]);

            $ticket->messages()->create([
                'sender' => 'user',
                'text'   => $message,
            ]);

            return redirect(route('carwash_ticket_edit', $ticket->id));
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.there_is_problem_to_send_ticket')]);
        }

    }

    public function edit(Ticket $ticket)
    {
        $carwash = $this->request->current_carwash;

        if ($carwash->id != $ticket->ticketable->id) {
            abort('403');
        }

        return view('carwash.tickets.edit', compact('ticket', 'carwash'));
    }

    public function update(Ticket $ticket, ticketMessageRequest $request)
    {
        try {

            $message = $request->input('message');
            $carwash = $this->request->current_carwash;

            if ($carwash->id != $ticket->ticketable->id) {
                abort('403');
            }

            $ticket->messages()->create([
                'sender' => 'user',
                'text'   => $message,
            ]);
            return redirect(route('carwash_ticket_edit', $ticket->id));
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.there_is_problem_to_send_message')]);
        }
    }
}
