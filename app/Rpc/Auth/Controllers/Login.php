<?php

namespace App\Rpc\Auth\Controllers;

use Auth;
use Result;
use App\Models\User;
use GatewayClient\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

/**
 * 登录管理
 * 
 * @author Zhaoqiang Liu
 * 
 * @version $Revision: 1.0 $
 */
class Login extends Controller
{  
      /**
     * 处理请求
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // 通过手机号获取用户
        $input = $request->only(['mobile']);
        $user = User::where('mobile', $input['mobile'])
                            ->first();
        if ($user) {
            // 将用户登录至系统中
            Auth::guard('web')->login($user);
                
            return ['auth' => true];
        }
    }
}