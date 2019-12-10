<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{  
    public function index()
    {
        return view('chat.index');
    }
}