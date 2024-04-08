<?php

namespace App\Http\Controllers\Servant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ticketMessageRequest;
use App\Http\Requests\ticketStoreRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $servant = $this->request->current_servant;

        $tickets = $servant->tickets()->orderBy("created_at", "desc")->get();

        return view('servant.tickets.index', compact('tickets', 'servant'));
    }

    public function create()
    {
        $servant = $this->request->current_servant;

        return view('servant.tickets.create', compact('servant'));
    }

    public function store(ticketStoreRequest $request)
    {
        try {
            $title = $request->input('title');
            $message = $request->input('message');
            $servant = $this->request->current_servant;

            $ticket = $servant->tickets()->create([
                'title'  => $title,
                'status' => "pending",
            ]);

            $ticket->messages()->create([
                'sender' => 'user',
                'text'   => $message,
            ]);

            return redirect(route('servant_ticket_edit', $ticket->id));
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.there_is_problem_to_send_ticket')]);
        }

    }

    public function edit(Ticket $ticket)
    {
        $servant = $this->request->current_servant;

        if ($servant->id != $ticket->ticketable->id) {
            abort('403');
        }

        return view('servant.tickets.edit', compact('ticket', 'servant'));
    }

    public function update(Ticket $ticket, ticketMessageRequest $request)
    {
        try {

            $message = $request->input('message');
            $servant = $this->request->current_servant;

            if ($servant->id != $ticket->ticketable->id) {
                abort('403');
            }

            $ticket->messages()->create([
                'sender' => 'user',
                'text'   => $message,
            ]);
            return redirect(route('servant_ticket_edit', $ticket->id));
        } catch (\Exception) {
            return redirect()->back()->withErrors(['error' => trans('trs.there_is_problem_to_send_message')]);
        }
    }
}
