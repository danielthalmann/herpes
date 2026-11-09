<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class TicketTimesheetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $ticket)
    {
        return view('herpes::tickettimesheet', ['ticket' => $ticket]);
    }
}
