<?php

namespace App\Rpc\Auth\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * 处理用户退出请求。
 *
 * @author Zhaoqiang Liu
 *
 * @version $Revision: 1.0 $
 */
class Logout extends Controller
{
    /**
     * 处理请求。
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        return ['logout' => true];
    }
}