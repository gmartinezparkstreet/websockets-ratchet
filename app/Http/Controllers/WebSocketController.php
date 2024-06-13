<?php

namespace App\Http\Controllers;

class WebSocketController extends Controller
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

    public function client()
    {
        return view('WebSocketClient');
    }

    public function message()
    {
        return view('MessageToClient');
    }
}
