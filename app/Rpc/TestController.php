<?php

namespace App\Rpc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $client = new \Hprose\Socket\Client('tcp://192.168.56.1:1024', false);
        $data = json_encode($request->except('prefix', 'function'));
        $prefix = $request->class;
        $function = $request->function;

        return $client->player->getData(158);
    }

}