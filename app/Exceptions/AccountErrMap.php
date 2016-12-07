<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/9/6
 * Time: 16:34
 */
namespace App\Exceptions;

class AccountErrMap extends ErrMapBase{

    const ERROR_PARAMETERS                      = 11015;
    const ERROR_NOT_FOUND_SECURITY_CODE         = 11016;
    const ERROR_ACCOUNT_LOCKED                  = 11020;
    const ERROR_LOGIN_FAILED                    = 11021;
    const ERROR_SECURITY_CODE_FREQUENCY         = 11022;
    const ERROR_REGISTER_PUSH_REGISTRATION_ID_FAIL = 11026;
    const ERROR_NOT_REGISTER_USERNAME           = 11029;
    const ERROR_HAD_REGISTER_USERNAME           = 11030;
    const ERROR_REGISTER_USER_FAIL              = 11031;
    const ERROR_ACCOUNT_ABNORMAL                = 11032;
    const ERROR_PHOTO_STORAGE_ANOMALY           = 11033;
    const ERROR_LICENSE_STORAGE_ANOMALY         = 11034;
    const ERROR_LOGIN_AUTHORIZER_FAIL           = 11035;
    const ERROR_AUTHORIZER_FAIL                 = 11036;
    const ERROR_RPC_GET_AUTH_CODE_FAIL          = 11037;

    //show to user
    const ERROR_PHONE_INVALID                   = 31003;
    const ERROR_NO_AUTHENTICATED                = 31006;
    const ERROR_SECURITY_CODE_EMPTY             = 31007;
    const ERROR_SECURITY_CODE_INVALID           = 31008;
    const ERROR_SECURITY_CODE_EXPIRE            = 31009;
    const ERROR_NOT_FOUND_USER                  = 31011;
    const ERROR_REGISTER_MORE_FAILED            = 31018;
    const ERROR_UPLOAD_PHOTO_ERROR              = 31023;

    protected function _getErrMsgMapping()
    {
        return [
            self::ERROR_PARAMETERS=> '请求参数错误',
            self::ERROR_PHONE_INVALID => '手机号格式错误',
            self::ERROR_NO_AUTHENTICATED => '用户没有权限',
            self::ERROR_SECURITY_CODE_EMPTY => '手机验证码错误',
            self::ERROR_SECURITY_CODE_INVALID => '验证码无效',
            self::ERROR_SECURITY_CODE_EXPIRE => '验证码已过期',
            self::ERROR_NOT_FOUND_USER => '用户不存在',
            self::ERROR_NOT_FOUND_SECURITY_CODE => '验证码不存在',
            self::ERROR_REGISTER_MORE_FAILED => '完善注册信息失败',
            self::ERROR_ACCOUNT_LOCKED => '帐号已锁定',
            self::ERROR_LOGIN_FAILED => '用户名或密码错误，登录失败',
            self::ERROR_SECURITY_CODE_FREQUENCY => '发送验证码频率太快',
            self::ERROR_UPLOAD_PHOTO_ERROR => '上传图像失败',
            self::ERROR_REGISTER_PUSH_REGISTRATION_ID_FAIL => '注册推送码错误',
            self::ERROR_NOT_REGISTER_USERNAME => '该手机号未注册',
            self::ERROR_HAD_REGISTER_USERNAME => '该手机号已经注册',
            self::ERROR_REGISTER_USER_FAIL => '用户注册失败',
            self::ERROR_ACCOUNT_ABNORMAL => '用户账号异常',
            self::ERROR_PHOTO_STORAGE_ANOMALY => '用户头像存储异常',
            self::ERROR_LICENSE_STORAGE_ANOMALY => '医生执照存储异常',
            self::ERROR_LOGIN_AUTHORIZER_FAIL => '登陆认证失败',
            self::ERROR_AUTHORIZER_FAIL => '用户认证失败',
            self::ERROR_RPC_GET_AUTH_CODE_FAIL => '远程调用获取验证码接口失败',
        ];
    }
}