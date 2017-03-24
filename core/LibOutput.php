<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:09
 */

namespace sinri\musikago\core;


use sinri\musikago\core\Musikago;

class LibOutput extends BaseLibrary
{
    const AJAX_JSON_CODE_OK="OK";
    const AJAX_JSON_CODE_FAIL="FAIL";

    public function __construct()
    {
        parent::__construct();
    }

    public function shortName()
    {
        return "output";
    }

    public function json($anything){
        echo json_encode($anything);
    }

    /**
     * @param string $code OK or FAIL
     * @param mixed $data
     */
    public function jsonForAjax($code=self::AJAX_JSON_CODE_OK,$data=''){
        echo json_encode(["code"=>$code,"data"=>$data]);
    }

    public function view($name,$params=[]){
        $filename= __DIR__ . '/../view/' .$name.'.php';
        extract($params);
        require $filename;
    }

    public function error($message='',$exception=null){
        // TODO: beautify it.
        echo "<pre>".PHP_EOL;
        echo $message;
        echo PHP_EOL;
        if($exception)var_dump($exception);
    }
}