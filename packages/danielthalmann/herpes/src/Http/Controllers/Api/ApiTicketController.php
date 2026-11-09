<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Carbon\Carbon;
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

        $query->with(['timesheets']);
        $tickets = $query->paginate($request->input('paginate', 20));
        $tickets->each(function ($ticket) {
            $ticket->times = 0.0;
            $ticket->times_planning_calculate = floatval($ticket->times_planning);

            if ($ticket->type === 'EPIC') {

                $ticket->children()->join('timesheets', 'tickets.id', '=', 'timesheets.ticket_id')->get()->each(function ($timesheet) use ($ticket) {
                    if($timesheet->start) {
                        $ticket->times += floatval(Carbon::parse($timesheet->start)->diffInMinutes(Carbon::parse($timesheet->end)));
                    }
                });

                $ticket->children->each(function ($timesheet) use ($ticket) {
                    $ticket->times_planning_calculate += floatval($timesheet->times_planning);
                });                

            }

            $ticket->timesheets->each(function ($timesheet) use ($ticket) {
                $ticket->times += floatval($timesheet->start->diffInMinutes($timesheet->end));
            });
            $ticket->times /= 60.0;
        });

        return $tickets;
    }

    /**
     * Display a listing of the resource.
     */
    public function epicIndex(Request $request)
    {
        $query = Ticket::query()->where('parent_id', null)->where('type', 'EPIC');

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
        $ticket->type = $request->input('type') ?? 'TICKET';
        $ticket->status = $request->input('status') ?? 'TODO';
        $ticket->summary = $request->input('summary');
        $ticket->description = $request->input('description');
        $ticket->times_planning = $request->input('times_planning');
        $ticket->customer_id = $request->input('customer_id');
        $ticket->parent_id = $request->input('parent_id');
        $ticket->reporter_id = request()->user()->id;
        $ticket->assignee_id = $request->input('assignee_id');
        $ticket->invoice = $request->input('invoice', false);
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
            $ticket->type = $request->input('type') ?? 'TICKET';
            $ticket->status = $request->input('status') ?? 'TODO';
            $ticket->summary = $request->input('summary');
            $ticket->description = $request->input('description');
            $ticket->customer_id = $request->input('customer_id');
            $ticket->parent_id = $request->input('parent_id');
            $ticket->reporter_id = $request->input('reporter_id');
            $ticket->assignee_id = $request->input('assignee_id');
            $ticket->times_planning = $request->input('times_planning');
            $ticket->invoice = $request->input('invoice', false);
            $ticket->invoiced_at = $request->input('invoiced_at');

            if ($ticket->type === 'EPIC') {
                $ticket->parent_id = null;
                Ticket::query()->where('parent_id', $ticket->id)->update(['customer_id' => $ticket->customer_id]);
                Ticket::query()->where('parent_id', $ticket->id)->where(function ($query) { $query->whereNull('assignee_id')->orWhere('assignee_id', '=', ''); })->update(['assignee_id' => $ticket->assignee_id]);
            }

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
