<?php

namespace Danielthalmann\Herpes\Http\Controllers;

use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('herpes::timesheet');
    }
}
