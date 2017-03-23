<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/23
 * Time: 11:09
 */

namespace sinri\musikago\library;


use sinri\musikago\core\Musikago;

class LibOutput extends BaseLibrary
{
    public function __construct()
    {
        parent::__construct();
    }

    public function json($anything){
        echo json_encode($anything);
    }

    public function jsonForAjax($code='OK',$data=''){
        echo json_encode(["code"=>$code,"data"=>$data]);
    }

    public function view($name,$params=[]){
        extract($params);
        $this->Musikago->loadView($name);
    }

    public function error($message='',$exception=null){
        // TODO: beautify it.
        echo "<pre>".PHP_EOL;
        echo $message;
        echo PHP_EOL;
        if($exception)var_dump($exception);
    }
}