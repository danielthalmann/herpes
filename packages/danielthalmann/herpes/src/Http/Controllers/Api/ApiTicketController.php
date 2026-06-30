<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\Ticket;
use Illuminate\Http\Request;

class ApiTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->input('search')) {
            $query->where('summary', 'like', '%' . $request->input('search') . '%');
        }

        return $query->paginate($request->input('paginate', 20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ticket = new Ticket();
        $ticket->type        = $request->input('type');
        $ticket->status      = $request->input('status');
        $ticket->summary     = $request->input('summary');
        $ticket->description = $request->input('description');
        $ticket->customer_id = $request->input('customer_id');
        $ticket->parent_id   = $request->input('parent_id');
        $ticket->reporter_id = $request->input('reporter_id');
        $ticket->assignee_id = $request->input('assignee_id');
        $ticket->invoice     = $request->input('invoice', false);
        $ticket->invoiced_at = $request->input('invoiced_at');
        $ticket->save();

        return $ticket;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        return new Ticket();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Ticket::query()->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Ticket::query()->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Ticket::query()->find($id);

        if ($ticket) {
            $ticket->type        = $request->input('type');
            $ticket->status      = $request->input('status');
            $ticket->summary     = $request->input('summary');
            $ticket->description = $request->input('description');
            $ticket->customer_id = $request->input('customer_id');
            $ticket->parent_id   = $request->input('parent_id');
            $ticket->reporter_id = $request->input('reporter_id');
            $ticket->assignee_id = $request->input('assignee_id');
            $ticket->invoice     = $request->input('invoice', false);
            $ticket->invoiced_at = $request->input('invoiced_at');
            $ticket->save();
        }

        return $ticket;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::query()->find($id);
        if ($ticket) {
            $ticket->delete();
        }

        return $ticket;
    }
}
