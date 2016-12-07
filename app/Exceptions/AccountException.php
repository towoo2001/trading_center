<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/9/6
 * Time: 16:36
 */
namespace App\Exceptions;


class AccountException extends CustomException {

    protected function  _getErrMsgClass(){
        return new AccountErrMap();
    }
}