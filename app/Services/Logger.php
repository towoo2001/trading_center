<?php
/**
 * Created by PhpStorm.
 * User: t
 * Date: 2016/12/2
 * Time: 11:12
 */
namespace App\Services;

use Illuminate\Support\Facades\Log;

class Logger {

    private static $_instance;

    /**
     * Get instance
     * @return Logger
     */
    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Create a new log writer instance.
     * @return void
     */
    public function __construct(){}

    /**
     * Log an error message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function error($message, array $context = [])
    {
        $message = $this->writeCommonLog($message);
        return Log::error($message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function warning($message, array $context = [])
    {
        $message = $this->writeCommonLog($message);
        return Log::warning($message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function notice($message = '', array $context = [])
    {
        $message = $this->writeCommonLog($message);
        return Log::notice($message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function info($message, array $context = [])
    {
        $message = $this->writeCommonLog($message);
        return Log::info($message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return void
     */
    public function debug($message, array $context = [])
    {
        $message = $this->writeCommonLog($message);
        return Log::debug($message, $context);
    }

    public function addHeaderInfo($request){
        $headers = $request->headers->all();
        if(count($headers)){
            foreach ($headers as $key => $value) {
                if(count($value)==1){
                    $this->addArray("HEADER",$key.'='.$value[0]);
                }else{
                    $this->addArray("HEADER",$key.'='.json_encode($value));
                }
            }
        }
    }

    // 生成logid
    public function genLogID()
    {
        if(defined('LOG_ID')){
            return LOG_ID;
        }

        if(!empty($_SERVER['HTTP_X_BD_LOGID']) && intval(trim($_SERVER['HTTP_X_BD_LOGID'])) !== 0){
            define('LOG_ID', trim($_SERVER['HTTP_X_BD_LOGID']));
        }elseif(isset($_REQUEST['logid']) && intval($_REQUEST['logid']) !== 0){
            define('LOG_ID', intval($_REQUEST['logid']));
        }else{
            $arr = gettimeofday();
            $logId = ((($arr['sec']*100000 + $arr['usec']/10) & 0x7FFFFFFF) | 0x80000000);
            define('LOG_ID', $logId);
        }
        return LOG_ID;
    }

    public function addArray($key, $value){
        if(!isset($this->addNotice[$key])){
            $array = array();
            $this->addNotice[$key] = &$array;
        }else{
            $array =  &$this->addNotice[$key];
        }
        array_push($array,$value);
    }

    public function addValue($key, $value)
    {
        $this->addNotice[$key] = $value;
    }

    private function formatCustomerInfo(&$format,$key_array){
        if(isset($key_array)){
            foreach ($key_array as $key) {
                if(isset($this->addNotice[$key])) {
                    $value = $this->addNotice[$key];
                    if(is_array($value)){
                        $format[$key] = implode("\n",$value);
                    }else{
                        $format[$key] = $value;
                    }
                }else{
                    $format[$key] = '';
                }
            }
        }
    }

    private function writeCommonLog($src)
    {

        $str = '';
        $format['LOG_ID'] = $this->genLogID() . "";
        $format['CLIENT_IP'] = (defined('CLIENT_IP')? CLIENT_IP : $this->getClientIp());
        if(isset($_SERVER['REQUEST_URI'])) {
            $format['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
        }
        if(isset($_SERVER['SERVER_ADDR'])) {
            $format['SERVER_ADDR'] = $_SERVER['SERVER_ADDR'];
        }
        if(isset($_SERVER['REQUEST_METHOD'])) {
            $format['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'];
        }
        if(isset($_SERVER['HOSTNAME'])) {
            $format['HOSTNAME'] = $_SERVER['HOSTNAME'];
        }
        if(isset($_SERVER['HTTP_HOST'])) {
            $format['HTTP_HOST'] = $_SERVER['HTTP_HOST'];
        }
        if(isset($_SERVER['SERVER_PORT'])) {
            $format['SERVER_PORT'] = $_SERVER['SERVER_PORT'];
        }

        $key_array = [
            'COST_TOTAL_TIME',
            'CONTROLLER',
            'PARAMS',
            'HEADER',
            'MSG',
            'STATUS',
            'ERRNO',
            'MSG',
            'SQL',
            'EXCEPTION'
        ];
        $this->formatCustomerInfo($format,$key_array);

        foreach($format as $key => $value){
            $str .= " " . $key . "[" . $value . "]";
        }
        if(!empty($src)){
            return $str . " " . $src."\n[]";
        }else{
            return $str."\n[]";
        }
    }

    private function getClientIp()
    {
        $uip = '';
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')) {
            $uip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            strpos($uip, ',') && list($uip) = explode(',', $uip);
        } else if(!empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $uip = $_SERVER['HTTP_CLIENT_IP'];
        } else if(!empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $uip = $_SERVER['REMOTE_ADDR'];
        }
        return $uip;
    }
}