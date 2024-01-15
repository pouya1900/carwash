<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTicketRequest;
use App\Http\Requests\Api\UpdateTicketRequest;
use App\Http\Resources\TicketFullResource;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\ResponseUtilsTrait;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use ResponseUtilsTrait;

    public function index()
    {
        try {
            $user = $this->request->user;

            $per_page = $this->getPerPage();

            $tickets = $user->tickets()->paginate($per_page);

            return $this->sendResponse([
                "tickets"    => TicketResource::collection($tickets),
                'pagination' => [
                    "totalItems"      => $tickets->total(),
                    "perPage"         => $tickets->perPage(),
                    "nextPageUrl"     => $tickets->nextPageUrl(),
                    "previousPageUrl" => $tickets->previousPageUrl(),
                    "lastPageUrl"     => $tickets->url($tickets->lastPage()),
                ],
            ]);
        } catch (\Exception) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

    public function show(Ticket $ticket)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $ticket->ticketable->id || $ticket->ticketable_type != User::class) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            return $this->sendResponse([
                "ticket" => new TicketFullResource($ticket),
            ]);
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function store(StoreTicketRequest $request)
    {
        try {
            $user = $this->request->user;

            $ticket = $user->tickets()->create([
                "title"  => $request->input("title"),
                "status" => "pending",
            ]);

            $ticket->messages()->create([
                "text"   => $request->input("message"),
                "sender" => "user",
            ]);

            return $this->sendResponse([
                "ticket" => new TicketResource($ticket),
            ], trans("messages.crud.createdModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }


    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        try {
            $user = $this->request->user;

            if ($user->id != $ticket->ticketable->id || $ticket->ticketable_type != User::class) {
                return $this->sendError(trans('messages.crud.illegalAccess'));
            }

            $ticket->update([
                "status" => "pending",
            ]);

            $ticket->messages()->create([
                "text"   => $request->input("message"),
                "sender" => "user",
            ]);

            return $this->sendResponse([
                "ticket" => new TicketResource($ticket),
            ], trans("messages.crud.updatedModelSuccess"));
        } catch (\Exception $e) {
            return $this->sendError(trans('messages.response.failed'));
        }
    }

}
