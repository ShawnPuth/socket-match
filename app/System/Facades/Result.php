<?php
namespace App\System\Facades;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;


/***
 * Class Service Response
 * 服务端接口数据返回facade
 * @package system\Facades
 */
class Result extends Response {

	const OK = [0, 'success'];
	const SYSTEM_ERROR = [-1, '系统内部错误'];
	const PARAMS_ERROR = [-2, '参数错误'];
	const USER_NOT_LOGIN = [-3, '未登录'];
	const REQUEST_ERROR = [-6, '错误的请求'];
	const USER_LOGIN_FAIL = [10000, '登录失败'];
	const USER_TOKEN_FAIL = [10001, '登录失败'];
	const USER_MOBILE_EXISTS = [10002, '手机号已存在'];
	const USER_NOT_FOUND = [10003, '用户不存在'];
	const USER_IS_BLACK = [10004, '用户是黑名单'];
    const TOKEN_EXPIRED = [10005, 'token expired.'];
    const TOKEN_INVALID = [10006, 'token invalid.'];
    const TOKEN_ABSENT = [10007, 'token absent.'];
    const USER_NOT_BIND = [10008, '用户未绑定'];
    const USER_NOT_BIND_MOBILE = [10010, '用户未绑定手机号'];
    const USER_UNIONID_EXISTS = [10010, '用户已存在'];
	const UPLOADNO_FILE = [10100, '未选择文件'];
    const UPLOAD_FAIL = [10101, '上传失败'];
    const USER_NOT_AUTHED = [10102, '无实名认证记录'];
    const COMPANY_NOT_AUTHED = [10103, '无企业认证记录'];
    const USER_NOT_LINK_TO_COMPANY = [40001, '用户未绑定法务公司'];
    const DATA_EMPTY = [50001, '数据为空'];
	const VERIFY_CODE_ERROR = [90000, '验证码错误'];
	const VERIFY_CODE_TIMEOUT = [90001, '验证码失效'];
	const SMS_TPLID_NULL = [91000, '短信发送失败(SMSidNull)'];
	const SMS_RATE_ERROR = [91001, '60秒内只能发送一次'];
	const BIND_SELFBINDED = [92000, '此手机号已与当前账号绑定'];
	const BIND_WILLRELIEVE = [92001, '此手机号已与其他帐号绑定, 如果继续将会解绑之前帐号'];
	const BIND_WILLMERGE = [92002, '此手机号已通过其他方式注册, 如果继续将会合并账号信息'];
	const BIND_ERROR = [92003, '绑定失败'];
	const BIND_NOTOPEN = [92004, '未开启绑定'];
    const BIND_CONFIRM = [92005, '绑定确认'];

    /**
     * [error description]
     * @Author    Jamie
     * @Datetime  2018-07-19T10:35:48+0800
     * @Copyright [copyright]
     * @License   [license]
     * @Version   [version]
     * @return    [type]                   [description]
     */
    public static function error($errno) {
    	return self::message($errno);
    }

    /**
     * [sucess description]
     * @Author    Jamie
     * @Datetime  2018-07-19T10:35:43+0800
     * @Copyright [copyright]
     * @License   [license]
     * @Version   [version]
     * @return    [type]                   [description]
     */
    public static function success($data, $message = '') {
    	return self::message(self::OK, $data, $message);
    }

    /**
     * [message description]
     * @Author    Jamie
     * @Datetime  2018-07-19T10:36:26+0800
     * @Copyright [copyright]
     * @License   [license]
     * @Version   [version]
     * @return    [type]                   [description]
     */
    public static function message($error, $data = null, $message = '') {

    	list($errno, $msg) = $error;
    	$ret['errno'] = $errno;

    	$ret['message'] = !empty($message) ? $message : $msg;

    	if($error[0] == 0 && empty($message)) {
    		unset($ret['message']);
		}
    	
    	$data && $ret['data'] = $data;
    	
    	return response()->json($ret, 200);
    }


    public static function notFound($message) {
    	return response()->json([
          	'message' => $message
      	], 404);
    }
}