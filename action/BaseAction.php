<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 13:53
 */

namespace sinri\musikago\action;


use sinri\musikago\core\Musikago;

class BaseAction
{
    const LOG_INFO = 'INFO';
    const LOG_WARNING = 'WARNING';
    const LOG_ERROR = 'ERROR';

    protected $Musikago;

    public function __construct()
    {
        $this->Musikago = Musikago::getInstance();
        if(!$this->Musikago->input->isCLI()){
            $this->log(self::LOG_ERROR,"You must run action under CLI environment.");
        }
    }

    protected function log($level,$message,$object=''){
        $now=date('Y-m-d H:i:s');

        echo "{$now} [{$level}] {$message} |";
        if(!is_string($object)) {
            echo json_encode($object, JSON_UNESCAPED_UNICODE);
        }elsE{
            echo $object;
        }
        echo PHP_EOL;
    }

    public function defaultMethod($params){
        print_r($params);
    }
}