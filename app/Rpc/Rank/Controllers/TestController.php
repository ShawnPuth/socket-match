<?php

namespace App\Rpc\Rank\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{  
    public function index()
    {
        return view('chat.index');
    }
}