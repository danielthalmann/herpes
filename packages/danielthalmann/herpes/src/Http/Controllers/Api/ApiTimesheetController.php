<?php

namespace Danielthalmann\Herpes\Http\Controllers\Api;

use Danielthalmann\Herpes\Http\Controllers\Controller;
use Danielthalmann\Herpes\Models\Timesheet;
use Illuminate\Http\Request;

class ApiTimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Timesheet::query();

        if ($request->input('search')) {
            $query->where('comment', 'like', '%' . $request->input('search') . '%');
        }

        return $query->paginate($request->input('paginate', 20));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $timesheet = new Timesheet();
        $timesheet->ticket_id = $request->input('ticket_id');
        $timesheet->start = $request->input('start');
        $timesheet->end = $request->input('end');
        $timesheet->comment = $request->input('comment');
        $timesheet->save();

        return $timesheet;
    }

    /**
     * Create the specified resource.
     */
    public function create()
    {
        return new Timesheet();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Timesheet::query()->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Timesheet::query()->find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $timesheet = Timesheet::query()->find($id);

        if ($timesheet) {
            $timesheet->ticket_id = $request->input('ticket_id');
            $timesheet->start = $request->input('start');
            $timesheet->end = $request->input('end');
            $timesheet->comment = $request->input('comment');
            $timesheet->save();
        }

        return $timesheet;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timesheet = Timesheet::query()->find($id);
        if ($timesheet) {
            $timesheet->delete();
        }

        return $timesheet;
    }
}
