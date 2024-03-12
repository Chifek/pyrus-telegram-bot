<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PyrusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function webhook(Request $request)
    {
        // todo send message to telegram bot
        // $request->post('event');
        // $request->post('access_token');
        // $request->post('task_id');
        // $request->post('user_id');
        // $request->post('task');
    }
    //
}
