<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2016/9/6
 * Time: 16:35
 */
namespace App\Exceptions;


class ErrMapBase {
    function getDisplayErrMsg($errno, $params = []) {
        if(!is_array($params)){
            $params = [];
        }
        $errMap = $this->_getErrMsgMapping();
        if (isset($errMap[$errno])) {
            $search  = [];
            $replace = [];
            foreach ($params as $k => $v) {
                $search[]  = ':' . $k;
                $replace[] = $v;
            }
            return str_replace($search, $replace, $errMap[$errno]);
        }
        return '';
    }
    protected function _getErrMsgMapping(){
        return [];
    }
}