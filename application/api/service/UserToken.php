<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/30
 * Time: 17:09
 */

namespace app\api\service;


use app\api\model\User;
use app\lib\enmu\ScopeEnmu;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;



    function __construct($code) {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get() {
        $result = curl_http($this->wxLoginUrl, 'GET');
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取openid及session_key失败，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }
    }


    private function grantToken($wxResult) {
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if($user) {
            $uid = $user->id;
        } else {
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue) {
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');

        $request = cache($key, $value, $expire_in);
        if(!$request) {
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult, $uid) {
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        // scope的值越大，权限越大
        // scope：16代表客户
//        $cachedValue['scope'] = 16;
        $cachedValue['scope'] = ScopeEnmu::User;
        // scope：32代表是CMS(管理员)

        return $cachedValue;
    }

    private function newUser($openid) {
        $user = UserModel::create([
            'openid' => $openid
        ]);
        return $user->id;
    }

    private function processLoginError($wxResult) {
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}