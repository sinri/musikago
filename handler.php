<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2017/3/25
 * Time: 14:07
 */

require_once (__DIR__.'/vendor/autoload.php');
require_once (__DIR__.'/core/Musikago.php');
use sinri\musikago\core\Musikago;

$musikago=Musikago::getInstance();

if(php_sapi_name() !== 'cli'){
    echo "Must run this under CLI environment.".PHP_EOL;
    echo "Such as: php handler.php BaseAction defaultMethod a b c".PHP_EOL;
    exit();
}

$arguments=[];
for($i=0;$i<$argc;$i++){
    $arguments[$i]=$argv[$i];
}

$action_name=isset($arguments[1])?$arguments[1]:'BaseAction';
$method_name=isset($arguments[2])?$arguments[2]:'defaultMethod';

$params=[];
if($argc>3){
    for($i=3;$i<$argc;$i++){
        $params[]=$arguments[$i];
    }
}

//echo $action_name.PHP_EOL;
//echo $method_name.PHP_EOL;
//print_r($params);

$musikago->runUnderCLI($action_name,$method_name,$params);
