<?php
/**
 * Created by PhpStorm.
 * User: ZWH
 * Date: 2019/6/30
 * Time: 19:14
 */

namespace app\api\service;


use app\lib\enmu\ScopeEnmu;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken() {
        $randChars = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.salt');

        return md5($randChars.$timestamp.$salt);
    }


    public static function getCurrentTokenVar($key) {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if(!$vars) {
            throw new TokenException();
        } else {
            if(!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if(array_key_exists($key, $vars)) {
                return $vars[$key];
            } else {
                throw new Exception('尝试获取的Token变量不存在');
            }
        }
    }


    public static function getCurrentUid() {
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }


    // 管理员和用户都能访问的权限
    public static function needPrimaryScope() {
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope >= ScopeEnmu::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }

    // 只能用户访问的权限
    public static function needExclusiveScope() {
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope == ScopeEnmu::User) {
                return true;
            } else {
                throw new ForbiddenException();
            }
        } else {
            throw new TokenException();
        }
    }
}