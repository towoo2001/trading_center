<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/9/5
 * Time: 20:54
 */

namespace App\Exceptions;

use Exception;

abstract class CustomException extends Exception {

    abstract protected function  _getErrMsgClass();
    public function __construct($errno, $msg = ''){
        if ($msg == '' || is_array($msg)) {
            $msg =  $this->_getErrMsgClass()->getDisplayErrMsg($errno, $msg);
        }
        parent::__construct($msg, $errno);
    }
    
}